<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DB;

class AdminController extends Controller
{
    
    public function index($id=0)
    {
        if((session('role')=='admin') && session('email')){
            return redirect('/admin/equipes');
        }else{
            if($id){
                $admin = DB::select("select * from admins where admin_badge='".$id."'");
                if(count($admin)>0){
                    return view('admin.login')->with('admin_name',$admin['0']->admin_name);
                }else{
                    return redirect('/');
                }
            }else{
                return redirect('/');
            }
        }

        /*$salt = password_hash($id, PASSWORD_BCRYPT,['playgroundfinder',1]);
        $hash = md5($salt . $id);

        return ['real_pwd'=>$id,'pwd'=>$hash,'hash'=>$salt ];*/
        
    }
   
    public function auth_admin(Request $request){
        if($request){
            $admin = DB::select("select * from admins where admin_email='".$request->email."'");
            if(count($admin)>0){
                $password = md5($admin['0']->admin_pwdhash . $request->password);

                if($password == $admin['0']->admin_pwd){

                    session(['role' => 'admin']);
                    session(['email' => $admin['0']->admin_email]);
                    session(['badge' => $admin['0']->admin_badge]);
                    return redirect('/admin/equipes');

                }else{

                    return view('admin.login')->with(['admin_name'=>$admin['0']->admin_name,'error'=>'Mot de passe erroné']);

                }
            }else{
                return view('admin.login')->with('error','Email erroné');
            }
        }else{
            return redirect('/');
        }
        
    }

    public function equipes(){

        if((session('role')=='admin') && session('email')){

            $teams = DB::select("select teams.team_id,team_name,team_email,phone,team_status,logo,team_joined,team_stat_win,team_stat_lose,team_stat_draw,type_abs.typeab_name,abn_start,abn_end,quartier_name_fr,abonnements.abn_remaininghours from teams join abonnements on teams.team_id=abonnements.team_id join type_abs ON abonnements.typeab_id = type_abs.typeab_id join quartiers  ON teams.quartier_id = quartiers.quartier_id");
            return view('admin.equipes')->with('teams',$teams);
        }else{
            return redirect('/');
        }
    }

    public function terrains(){
        if((session('role')=='admin') && session('email')){
            return view('admin.terrains');
        }else{
            return redirect('/');
        }
    }

    public function getTers(){
        if((session('role')=='admin') && session('email')){
            $terrs = DB::select("select terrain_id,terrain_name_fr,terrain_name_ar,terrain_email,terrain_phone,quartier_id,ST_AsGeoJSON(terrain_position) as latlngs from terrains");

            $features = array();
            foreach($terrs as $terrain){

                $feature = array(
                    "type"      => "Feature",
                    "properties"  => array(
                        "id"=>"".$terrain->terrain_id."",
                        "name_fr"=>"".$terrain->terrain_name_fr."",
                        "name_ar"=>"".$terrain->terrain_name_ar."",
                        "email"=>"".$terrain->terrain_email."",
                        "phone"=>"".$terrain->terrain_phone."",
                        "qtId"=>"".$terrain->quartier_id.""
                    ),
                    "geometry" => json_decode($terrain->latlngs)
                );
                array_push($features,$feature);
            }
            $terrains = array(
                'type'      => 'FeatureCollection',
                'features'  => $features
            );

            $qts = DB::select("select quartier_id,quartier_name_fr,quartier_name_ar,ST_AsGeoJSON(quartier_position) as latlngs from quartiers");

            $features = array();
            foreach($qts as $quartier){

                $feature = array(
                    "type"      => "Feature",
                    "properties"  => array(
                        "id"=>"".$quartier->quartier_id."",
                        "name_fr"=>"".$quartier->quartier_name_fr."",
                        "name_ar"=>"".$quartier->quartier_name_ar.""
                    ),
                    "geometry" => json_decode($quartier->latlngs)
                );
                array_push($features,$feature);
            }
            $quartiers = array(
                'type'      => 'FeatureCollection',
                'features'  => $features
            );
            
            return [$terrains,$quartiers];
        }else{
            return redirect('/');
        }        
    }

    public function addTerr(Request $request){
        if((session('role')=='admin') && session('email')){
            $query = DB::insert("insert into terrains(terrain_name_fr, terrain_name_ar,terrain_email,terrain_phone,quartier_id, terrain_position) VALUES('".$request->terrNameFr."','".$request->terrNameAr."','".$request->terrEmail."','".$request->terrPhone."','".$request->qtId."',PointFromText(ST_AsText(ST_GeomFromGeoJSON('".json_encode($request->geom)."'))))");
            return 'success';   
        }else{
            return redirect('/');
        }
    }

    public function editTerr(Request $request){
        if((session('role')=='admin') && session('email')){
            //$qr ="update terrains set terrain_name_fr='".$request->terrNameFr."', terrain_name_ar='".$request->terrNameAr."',terrain_email='".$request->terrEmail."',terrain_phone='".$request->terrPhone."'quartier_id='".$request->qtId."', terrain_position = PointFromText(ST_AsText(ST_GeomFromGeoJSON('".json_encode($request->geom)."'))) where terrain_id='".$request->terrId."'";
            $query = DB::update("update terrains set terrain_name_fr='".$request->terrNameFr."', terrain_name_ar='".$request->terrNameAr."',terrain_email='".$request->terrEmail."',terrain_phone='".$request->terrPhone."' , quartier_id=".$request->qtId.", terrain_position = PointFromText(ST_AsText(ST_GeomFromGeoJSON('".json_encode($request->geom)."'))) where terrain_id=".$request->terrId."");
            return 'success';   
        }else{
            return redirect('/');
        }
    }

    public function getTerRes(Request $request){
        if((session('role')=='admin') && session('email')){
            $res = DB::select('select teams.team_name,reservations.res_start,reservations.res_id,t.typeres_name from reservations join type_res t ON reservations.typeres_id = t.typeres_id join teams on reservations.team_id=teams.team_id where terrain_id='.$request->terrain_id.' and MONTH(res_start)='.$request->month.' and DAY(res_start)='.$request->day.' and YEAR(res_start)='.$request->year.' order by reservations.res_start');
            return ['status'=>'success','data'=>$res];
        }else{
            return redirect('/');
        }
        
    }

    public function deleteTerr(Request $request){
        if((session('role')=='admin') && session('email')){
            $terRes = DB::select('select * from reservations where YEAR(res_start) >= YEAR(now()) and MONTH(res_start) >= MONTH(now()) and DAY(res_start) >= DAY(now()) and terrain_id='.$request->terrId.'');
            if(count($terRes)>0){
                return 'reserved';
            }else{
                $query  = DB::delete('delete from terrains where terrain_id='.$request->terrId);
                return 'success';
            }
        }else{
            return redirect('/');
        }
    }

    public function quartiers(){
        if((session('role')=='admin') && session('email')){
            return view('admin.quartiers');
        }else{
            return redirect('/');
        }
        
    }

    public function getQts(){
        if((session('role')=='admin') && session('email')){
            $qts = DB::select("select quartier_id,quartier_name_fr,quartier_name_ar,ST_AsGeoJSON(quartier_position) as latlngs from quartiers");

            $features = array();
            foreach($qts as $quartier){

                $qtTeams = DB::select("select team_id,team_name,logo from teams where quartier_id=".$quartier->quartier_id);
                $qtTerrains = DB::select("select terrain_id,terrain_name_fr,terrain_email,terrain_phone from terrains where quartier_id=".$quartier->quartier_id);

                $qtData = array(
                    'teams'=>$qtTeams,
                    'terrains'=>$qtTerrains
                );

                $feature = array(
                    "type"      => "Feature",
                    "properties"  => array(
                        "id"=>"".$quartier->quartier_id."",
                        "name_fr"=>"".$quartier->quartier_name_fr."",
                        "name_ar"=>"".$quartier->quartier_name_ar."",
                        "qtData"=>$qtData
                    ),
                    "geometry" => json_decode($quartier->latlngs)
                );
                array_push($features,$feature);
            }
            $geojson = array(
                'type'      => 'FeatureCollection',
                'features'  => $features
            );
            
            return $geojson;
        }else{
            return redirect('/');
        }
        
    }

    public function addQt(Request $request){
        if((session('role')=='admin') && session('email')){
            $query = DB::insert("insert into quartiers(quartier_name_fr, quartier_name_ar, quartier_position) VALUES('".$request->qtNameFr."','".$request->qtNameAr."',PolygonFromText(ST_AsText(ST_GeomFromGeoJSON('".json_encode($request->geom)."'))))");
            return 'success';   
        }else{
            return redirect('/');
        }
        
    }

    public function delQt(Request $request){
        if((session('role')=='admin') && session('email')){
            $query  = DB::delete('delete from quartiers where quartier_id='.$request->qtId);
            return 'success';
        }else{
            return redirect('/');
        }
    }

    public function editQt(Request $request){
        if((session('role')=='admin') && session('email')){
            $query  = DB::update("update quartiers set quartier_name_fr='".$request->qtNameFr."', quartier_name_ar='".$request->qtNameAr."', quartier_position=PolygonFromText(ST_AsText(ST_GeomFromGeoJSON('".json_encode($request->geom)."'))) where quartier_id=".$request->id."");
            return 'success';
        }else{
            return redirect('/');
        }
    }

    public function reservations(){
        if((session('role')=='admin') && session('email')){
            $teams = DB::select("select teams.team_id,team_name,team_email,phone,team_status,logo,team_joined,team_stat_win,team_stat_lose,team_stat_draw,type_abs.typeab_name,abn_start,abn_end,quartier_name_fr,abonnements.abn_remaininghours from teams join abonnements on teams.team_id=abonnements.team_id join type_abs ON abonnements.typeab_id = type_abs.typeab_id join quartiers  ON teams.quartier_id = quartiers.quartier_id");
            $terrains = DB::select("select terrain_id,terrain_name_fr,terrain_name_ar,terrain_email,terrain_phone,ST_AsGeoJSON(terrain_position) as latlngs ,quartiers.quartier_name_fr from terrains join quartiers on quartiers.quartier_id=terrains.quartier_id  order by terrains.terrain_name_fr");
            return view('admin.reservations')->with(['teams'=>$teams,'terrains'=>$terrains]);
        }else{
            return redirect('/');
        }
        
    }

    public function getResEq(Request $request){
        if((session('role')=='admin') && session('email')){
            $resList = DB::select("select r.res_id,t.typeres_name,r.res_duration,r.res_start,r.res_end,terrains.terrain_name_fr from reservations r join terrains on terrains.terrain_id = r.terrain_id join type_res t on t.typeres_id = r.typeres_id where YEAR(r.res_start)='".$request->y."' and MONTH(r.res_start)='".$request->m."' and DAY(r.res_start)='".$request->d."' and r.team_id=".$request->teamId." order by r.res_start ");
            
            return $resList;
        }else{
            return redirect('/');
        }
    }

    public function getResTer(Request $request){
        if((session('role')=='admin') && session('email')){
            $resList = DB::select("select r.res_id,t.typeres_name,r.res_duration,r.res_start,r.res_end,teams.team_name from reservations r join teams on teams.team_id = r.team_id join terrains on terrains.terrain_id = r.terrain_id join type_res t on t.typeres_id = r.typeres_id where YEAR(r.res_start)='".$request->y."' and MONTH(r.res_start)='".$request->m."' and DAY(r.res_start)='".$request->d."' and r.terrain_id = ".$request->terId." order by r.res_start ");
            
            return $resList;
        }else{
            return redirect('/');
        }
    }

    public function delRes(Request $request){

        if((session('role')=='admin') && session('email')){

            $res = (DB::select('select * from reservations where res_id='.$request->resId))[0];

            $currTime = (DB::select('select now() as now'))[0]->now;
            
            $currTime = strtotime($currTime);
            $resTime = strtotime($res->res_start);

            if(round(($resTime - $currTime)/60 ,2)>120){

                $query  = DB::delete('delete from reservations where res_id='.$request->resId);
                $query  = DB::update('update abonnements set abn_remaininghours = abn_remaininghours + 1 where abn_id='.$res->abn_id);

                return 'success';
            }else{
                return 'error';
            }

        }else{
            return redirect('/');
        }
    }

    public function abonnements(){

        if((session('role')=='admin') && session('email')){
            $abs = DB::select('select ab.*,t.team_name,t.logo,types.typeab_name from abonnements ab join teams t on t.team_id = ab.team_id join type_abs types on types.typeab_id = ab.typeab_id order by ab.abn_end desc');
            $type_abs = DB::select('select typeab_id,typeab_name from type_abs');
            $teams = DB::select('select team_id,team_name from teams');
            return view('admin.abonnements')->with(['abonnements'=>$abs,'types'=>$type_abs,'teams'=>$teams]);
        }else{
            return redirect('/');
        }
        
    }

    public function findAbn(Request $request){


        if((session('role')=='admin') && session('email')){

            $query = 'select ab.*,t.team_name,t.logo,types.typeab_name from abonnements ab join teams t on t.team_id = ab.team_id join type_abs types on types.typeab_id = ab.typeab_id';

            if($request->typeAbn || $request->teamId || $request->startDate || $request->endDate){

                $query = $request->typeAbn ? $query.' where types.typeab_id='.$request->typeAbn : $query." where types.typeab_id LIKE '%'";

                $query = $request->teamId ? $query.' and ab.team_id='.$request->teamId : $query." ";

                $query = $request->startDate ? $query." and  YEAR(ab.abn_start)=YEAR('".$request->startDate."') and MONTH(ab.abn_start)=MONTH('".$request->startDate."')" : $query." ";

                $query = $request->endDate ? $query." and  YEAR(ab.abn_end)=YEAR('".$request->endDate."') and MONTH(ab.abn_end)=MONTH('".$request->endDate."')" : $query." ";
                
            }
            
            $abs = DB::select($query);
            $type_abs = DB::select('select typeab_id,typeab_name from type_abs');
            $teams = DB::select('select team_id,team_name from teams');
            return view('admin.abonnements')->with(['abonnements'=>$abs,'types'=>$type_abs,'teams'=>$teams]);

        }else{
            return redirect('/');
        }
    }

    public function admins(){

        if((session('role')=='admin') && session('email')){

            $myProfile = DB::select("select admin_badge,admin_email,admin_phone,admin_name from admins where admin_badge='".session('badge')."'");
            $teamsCount = DB::select('select count(*) as cnt from teams');
            $terCount = DB::select('select count(*) as cnt from terrains');
            $qtCount = DB::select('select count(*) as cnt from quartiers');
            $abnCount = DB::select('select count(*) as cnt from abonnements');       

            if (strpos($myProfile['0']->admin_badge, 'root') !== false) {

                $admins = DB::select('select admin_badge,admin_email,admin_phone,admin_name from admins');
                $rootAdmins = DB::select("select count(*) as cnt from admins where admin_badge like 'root%'");

                $stats = array(
                    'teams'=>$teamsCount['0']->cnt,
                    'terrains'=>$terCount['0']->cnt,
                    'quartiers'=>$qtCount['0']->cnt,
                    'abonnements'=>$abnCount['0']->cnt,
                    'admins'=>count($admins),
                    'rootAdmins'=>$rootAdmins['0']->cnt
                );

                return view('admin.admins')->with(['myInfo'=>$myProfile,'admins'=>$admins,'stats'=>$stats]);
            }else{

                $stats = array(
                    'teams'=>$teamsCount['0']->cnt,
                    'terrains'=>$terCount['0']->cnt,
                    'quartiers'=>$qtCount['0']->cnt,
                    'abonnements'=>$abnCount['0']->cnt
                );

                return view('admin.admins')->with(['myInfo'=>$myProfile,'stats'=>$stats]);

            }
            
        }else{
            return redirect('/');
        }
    }

    public function makeRoot(Request $request){
        if((session('role')=='admin') && session('email') && (strpos(session('badge'), 'root') !== false)){
            if(strpos($request->admin_badge, 'root') !== false){
                return 'alreadyRoot';
            }else{
                $query  = DB::update("update admins set admin_badge='root".$request->admin_badge."' where admin_email='".$request->admin_email."'");
                return 'success';
            }
        }else{
            return redirect('/');
        }
    }

    public function delAdmin(Request $request){
        if((session('role')=='admin') && session('email') && (strpos(session('badge'), 'root') !== false)){
            $query  = DB::delete("delete from admins where admin_badge='".$request->admin_badge."' and admin_email='".$request->admin_email."'");
            return 'success';
        }else{
            return redirect('/');
        }
    }

    public function addAdmin(Request $request){
        if((session('role')=='admin') && session('email') && (strpos(session('badge'), 'root') !== false)){

            $adminName = $request->adminName;
            $adminBagde = $request->adminBagde;
            $adminEmail = $request->adminEmail;
            $adminPhone = $request->adminPhone;
            $salt = password_hash($request->adminPassword, PASSWORD_BCRYPT,['fastfoot',1]);
            $pwd = md5($salt . $request->adminPassword);

            if(count(DB::select("select * from admins where admin_email='".$adminEmail."'"))>0){
                return 'Adresse email déjà utilisée';
            }else if(count(DB::select("select * from admins where admin_badge='".$adminBagde."'"))>0){
                return 'Numéro de badge déjà utilisé';
            }else{
                $query  = DB::insert("insert into admins(admin_name,admin_email,admin_phone,admin_badge,admin_pwd,admin_pwdhash) values('".$adminName."','".$adminEmail."','".$adminPhone."','".$adminBagde."','".$pwd."','".$salt."')");
                return 'success';
            }
        }else{
            return redirect('/');
        }
    }

    public function editAdmin(Request $request){
        if((session('role')=='admin') && session('email')){
            
            $adminName = $request->adminName;
            $adminBagde = $request->adminBagde;
            $adminEmail = $request->adminEmail;
            $adminPhone = $request->adminPhone;
            $salt = password_hash($request->adminPassword, PASSWORD_BCRYPT,['fastfoot',1]);
            $pwd = md5($salt . $request->adminPassword);

            $query  = DB::update("update admins set admin_name='".$adminName."', admin_phone='".$adminPhone."',admin_pwd='".$pwd."',admin_pwdhash='".$salt."' where admin_email='".$adminEmail."' and admin_badge='".$adminBagde."'");
            return 'success';
        }else{
            return redirect('/');
        }
    }
}
