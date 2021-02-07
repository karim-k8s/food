<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DB;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Input;
require '../vendor/autoload.php';
define ('SITE_ROOT', realpath(dirname(__FILE__)));


class TeamController extends Controller
{
    
    public function index()
    {
        //phpinfo();
        $chk = DB::select('select count(*) as cnt from admins')['0']->cnt;
        if($chk<1){
            $salt = password_hash('rootpassword', PASSWORD_BCRYPT,['fastfoot',1]);
            $pwd = md5($salt . 'rootpassword');
            $initQuery = DB::insert("insert into admins(admin_name,admin_email,admin_phone,admin_badge,admin_pwd,admin_pwdhash) values('Default Root Admin','root@fastfoot.com','0650951547','rootAdmin','".$pwd."','".$salt."')");
        }
        $chk = DB::select('select count(*) as cnt from type_abs')['0']->cnt;
        if($chk<1){
            $initQuery = DB::insert("insert into type_abs(typeab_name, typeab_duration, typeab_price, typerab_hoursamount) VALUES ('Mensuel',30,20,20)");
            $initQuery = DB::insert("insert into type_abs(typeab_name, typeab_duration, typeab_price, typerab_hoursamount) VALUES ('Trimestriel',90,50,60)");
            $initQuery = DB::insert("insert into type_abs(typeab_name, typeab_duration, typeab_price, typerab_hoursamount) VALUES ('Semestriel',180,95,120)");
            $initQuery = DB::insert("insert into type_abs(typeab_name, typeab_duration, typeab_price, typerab_hoursamount) VALUES ('Annuel',365,180,240)");
            $initQuery = DB::insert("insert into type_abs(typeab_name, typeab_duration, typeab_price, typerab_hoursamount) VALUES ('Version d essai',0,0,0)");
            $initQuery = DB::insert("insert into type_abs(typeab_name, typeab_duration, typeab_price, typerab_hoursamount) VALUES ('Version local',730,0,104)");
        }

        $chk = DB::select('select count(*) as cnt from type_res')['0']->cnt;
        if($chk<1){
            $initQuery = DB::insert("insert into type_res (typeres_name, typeres_duration) VALUES ('Match',1)");
            $initQuery = DB::insert("insert into type_res (typeres_name, typeres_duration) VALUES ('Entrainement',1)");
            $initQuery = DB::insert("insert into type_res (typeres_name, typeres_duration) VALUES ('Competition',10)");
        }

        if((session('role')=='team') && session('email')){
            $team = DB::select("select *,quartier_name_fr from teams join quartiers on teams.quartier_id = quartiers.quartier_id where team_email='".session('email')."'");
            $matches = DB::select("select count(*) cnt from reservations where date(now())>date(res_end) and  typeres_id=1 and team_id='".$team['0']->team_id."'");
            $trainings = DB::select("select count(*) cnt from reservations where typeres_id=2 and team_id='".$team['0']->team_id."'");
            $abns = DB::select("select count(*) cnt from abonnements where typeab_id!=5 and team_id='".$team['0']->team_id."'");
            $abnInfo = DB::select("select ab.*,tab.typeab_name from abonnements ab join type_abs tab on tab.typeab_id=ab.typeab_id join teams t on ab.team_id = t.team_id and t.team_email='".session('email')."' where ab.abn_end>now() order by ab.abn_end  DESC LIMIT 1");
            $favPg = DB::select("select tr.terrain_name_fr,rs.terrain_id,count(*) from fastfoot.reservations rs join fastfoot.terrains tr on tr.terrain_id=rs.terrain_id where rs.team_id='".$team['0']->team_id."'  group by rs.terrain_id;");
            $teamStats = array('matches'=>'','entrainements'=>'','abns'=>'','favTerrain'=>'');
            $typeRes = DB::select('select * from type_res where typeres_id!=3');
            $teams = DB::select('select team_name,team_id from teams where team_id !='.$team['0']->team_id);
            $abnTypes = DB::select('select * from type_abs where typeab_id!=5');
            $accepts = DB::select("select count(*) as accepts from matches where date(now())<=date(match_end) and hour(now())<hour(match_end) and accept=1 and hostteam_id=".$team['0']->team_id)['0']->accepts;
            $invits = DB::select("select count(*) as invits from matches where date(now())<=date(match_end) and hour(now())<hour(match_end) and accept=0 and guestteam_id=".$team['0']->team_id)['0']->invits;
            $compCount = DB::select("select count(*) as cnt from competitions where status='en cours'")['0']->cnt;
            $terrains = DB::select("select * from terrains");
            if($matches['0']){
                $teamStats['matches'] = $matches['0']->cnt;
            }
            if($abns['0']){
                $teamStats['abns'] = $abns['0']->cnt;
            }
            if($trainings['0']){
                $teamStats['entrainements'] = $trainings['0']->cnt;
            }
            if(count($favPg)>0){                
                $teamStats['favTerrain'] = $favPg['0']->terrain_name_fr;
            }
            
            $qts = DB::select("select quartier_id,quartier_name_fr from quartiers");
            return view('team.index')->with(['qts'=>$qts,'team'=>$team['0'],'terrains'=>$terrains,'teamStats'=>$teamStats,'typeRes'=>$typeRes,'teams'=>$teams,'abnTypes'=>$abnTypes,'abnInfo'=>$abnInfo['0'],'invits'=>$invits,'comps'=>$compCount,'accepts'=>$accepts]);
        }else{
            $abnTypes = DB::select('select * from type_abs where typeab_id!=5');
            $qts = DB::select("select quartier_id,quartier_name_fr from quartiers");
            return view('team.index')->with(['qts'=>$qts,'abnTypes'=>$abnTypes]);
        }
        
    }

    public function checkUserMail(Request $request){
        $mail = DB::select("select * from teams where team_email='".$request->email."'");

        if(count($mail)>0){
            return 'email used';
        }else{
            return 'email ok';
        }
    }

    public function checkUserCin(Request $request){
        $cin = DB::select("select * from local where cin='".$request->cin."'");

        if(count($cin)>0){
            return 'cin ok';
        }else{
            return 'cin erreur';
        }
    }
    public function getUserType(Request $request){
        $type = DB::select("select team_type from teams where team_email='".session('email')."'");

        if(count($type)>0){
            return $type['0']->team_type;
        }
    }
    
    public function loginTeam(Request $request){

        $team = DB::select("select * from teams where team_email='".$request->usermail."'");
        if(count($team)>0){
            
            $password = md5($team['0']->team_pwdhash . $request->userpwd);

            if($password == $team['0']->team_pwd){

                session(['role' => 'team']);
                session(['email' => $team['0']->team_email]);
                session(['t_type' => $team['0']->team_type]);
                return 'success';

            }else{

                return 'pwdError';

            }
        }else{
            return 'emailError';
        }
    }

    public function signupTeam(Request $request){

        
      
            $fileNameToStore = 'nologo.png';
        
        $teamName = $request->teamName;
        $teamPhone = $request->teamPhone;
        $teamEmail = $request->teamEmail;
        $teamQt = $request->teamQt;
        $salt = password_hash($request->teamPwd, PASSWORD_BCRYPT,['fastfoot',1]);
        $pwd = md5($salt . $request->teamPwd);
        
        //$query  = DB::insert("insert into teams(team_name,team_email,phone,quartier_id,team_pwd,team_pwdhash) values('".$teamName."','".$teamEmail."','".$teamPhone."',".$teamQt.",'".$pwd."','".$salt."')");
      
        if($request->teamSt == 'etudiant' || $request->teamSt == 'enseignant'){
            
            $teamSt = $request->teamSt;
            $insertedId = DB::table('teams')->insertGetId(
                [ 
                    'team_name' => $teamName,
                    'team_email' => $teamEmail,
                    'phone' => $teamPhone,
                    'quartier_id' => $teamQt,
                    'team_pwd' => $pwd,
                    'team_pwdhash' => $salt,
                    'logo'=>$fileNameToStore,
                    'team_type'=>$teamSt
                ]
            );
            $abnQuery = DB::insert('insert INTO abonnements(typeab_id, team_id, abn_start, abn_end, abn_remaininghours) VALUES (6,'.$insertedId.',now(),CURDATE() + INTERVAL 730 DAY,104);');
        }
        else{
            $teamSt = 'autre';
            $insertedId = DB::table('teams')->insertGetId(
                [ 
                    'team_name' => $teamName,
                    'team_email' => $teamEmail,
                    'phone' => $teamPhone,
                    'quartier_id' => $teamQt,
                    'team_pwd' => $pwd,
                    'team_pwdhash' => $salt,
                    'logo'=>$fileNameToStore,
                    'team_type'=>$teamSt
                ]
            );
            $abnQuery = DB::insert('insert INTO abonnements(typeab_id, team_id, abn_start, abn_end, abn_remaininghours) VALUES (5,'.$insertedId.',now(),CURDATE() + INTERVAL 30 DAY,5);');
        }
        
        return 'success';
        
    }

    public function editTeam(Request $request){
        $team = DB::select("select *,quartier_name_fr from teams join quartiers on teams.quartier_id = quartiers.quartier_id where team_email='".session('email')."'")['0'];

        
            $fileNameToStore = 'nologo.png';
        


        $query = "update teams set ";
        $query = isset($request->teamName) ? $query." team_name = '".$request->teamName."'" : $team->team_name;
        $query = isset($request->teamPhone) ? $query.", phone = '".$request->teamPhone."'" : $team->phone;
        $query = isset($request->teamQt) ? $query.", quartier_id = '".$request->teamQt."'" : $team->quartier_id;
        if($fileNameToStore!=''){
            $query = $query.", logo = '".$fileNameToStore."'";
        }
        if(isset($_POST['teamPwd'])){
            $salt = password_hash($request->teamPwd, PASSWORD_BCRYPT,['fastfoot',1]);
            $pwd = md5($salt . $request->teamPwd);

            $query = $query.", team_pwd = '".$pwd."',team_pwdhash='".$salt."'";
        }

        $query = $query." where team_id=".$team->team_id;

        $editTeamQuery = DB::update($query);

        
        return 'success';
    }

    public function getMapData(){
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
    }

    public function getResTers(Request $request){

        $query = 'select terrain_id,terrain_name_fr,terrain_name_ar,terrain_email,terrain_phone,quartier_id,ST_AsGeoJSON(terrain_position) as latlngs from terrains';

        if($request->qtId || $request->resTime){

            $query = $request->qtId ? $query.' where quartier_id='.$request->qtId : $query." where quartier_id LIKE '%'";

            $query = $request->resTime ? $query." and terrain_id not in (select rs.terrain_id from reservations rs where YEAR(rs.res_start)=YEAR('".$request->resTime."') and MONTH(rs.res_start)=MONTH('".$request->resTime."') and DAY(rs.res_start)=DAY('".$request->resTime."') and HOUR(rs.res_start)=HOUR('".$request->resTime."') )" : $query." ";
            
        }
        
        $ters = DB::select($query);
        $features = array();
        foreach($ters as $terrain){

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
        return ['ters'=>$terrains];
    }

    public function getResPlan(Request $request){
        $query = DB::select("select teams.team_name,rs.res_start,rs.res_id,t.typeres_name from reservations rs join type_res t ON rs.typeres_id = t.typeres_id join teams on rs.team_id=teams.team_id where rs.terrain_id =".$request->terId." and YEAR(rs.res_start)=".$request->y." and MONTH(rs.res_start)=".$request->m." and DAY(rs.res_start)=".$request->d."");
        if((session('role')=='team') && session('email')){
            $myResList = DB::select("select teams.team_name,rs.res_start,rs.res_id,t.typeres_name from reservations rs join type_res t ON rs.typeres_id = t.typeres_id join teams on rs.team_id=teams.team_id where rs.terrain_id =".$request->terId." and YEAR(rs.res_start)=".$request->y." and MONTH(rs.res_start)=".$request->m." and DAY(rs.res_start)=".$request->d." and teams.team_email='".session('email')."'");
            return ['resList'=>$query,'myResList'=>$myResList];
        }else{
            return ['resList'=>$query];
        }

        
    }

    public function addRes(Request $request){
        if((session('role')=='team') && session('email')){
            $remHours = (DB::select("select t.team_id,ab.abn_id,ab.abn_remaininghours from teams t join abonnements ab on ab.team_id = t.team_id and t.team_email='".session('email')."' where ab.abn_end>now() and ab.abn_start<=now() order by ab.abn_end  DESC LIMIT 1"))['0'];
            $rs = $request->resStart;
            $re = new DateTime($rs);
            $re->add(new DateInterval('PT1H'));
            if($remHours->abn_remaininghours > 0){
                $insertedRes = DB::table('reservations')->insertGetId(
                    [ 
                        'typeres_id' => $request->typeRes,
                        'team_id' => $remHours->team_id,
                        'abn_id' => $remHours->abn_id,
                        'terrain_id' => $request->terId,
                        'res_duration' => '1',
                        'res_start' => $rs,
                        'res_end' => $re->format('Y-m-d H:i')
                    ]
                );
                

                if($request->invTeam!='00'){
                    $matchQuery = DB::insert("insert into matches( hostteam_id, guestteam_id, res_id, terrain_id, match_result, match_start, match_end) values(".$remHours->team_id." , ".$request->invTeam." , ".$insertedRes." , ".$request->terId.", '0' ,'".$rs."','".$re->format('Y-m-d H:i')."')");
                }else{
                    $matchQuery = DB::insert("insert into matches( hostteam_id, guestteam_id, res_id, terrain_id, match_result, match_start, match_end) values(".$remHours->team_id." , null , ".$insertedRes." , ".$request->terId.", '0' ,'".$rs."','".$re->format('Y-m-d H:i')."')");
                }

                $updateHrsQuery = DB::update('update abonnements set  abn_remaininghours=abn_remaininghours-1 where abn_id='.$remHours->abn_id);

                return 'success';
            }else{
                return 'error';
            }
        }
    }

    public function cancelRes(Request $request){
        if((session('role')=='team') && session('email')){

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

        }
    }

    public function paymentProcess(Request $request){

        $oldAbn;

        if($request->newAbn=='false'){
            $oldAbn = (DB::select("select ab.abn_id,ab.abn_end from teams t join abonnements ab on ab.team_id = t.team_id and t.team_email='".session('email')."' where ab.abn_end>now() and ab.abn_start<=now() order by ab.abn_end  DESC LIMIT 1"))['0'];
        }

        $abnInfo   = (DB::select('select * from type_abs where typeab_id='.$request->typeAbId))['0'];

        $teamId = (DB::select("select team_id from teams where team_email='".session('email')."'")['0']->team_id);

        $ids = require('paypalConfig.php');

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $ids['id'],
                $ids['secret']
            )
        );

        $list = new \PayPal\Api\ItemList();

        $item = (new \PayPal\Api\Item())
            ->setName($abnInfo->typeab_name)
            ->setPrice($abnInfo->typeab_price)
            ->setQuantity('1')
            ->setCurrency('USD');
        $list->addItem($item);


        $amount = (new \PayPal\Api\Amount())
            ->setTotal($abnInfo->typeab_price)
            ->setCurrency('USD');

        $transaction = (new \PayPal\Api\Transaction())
            ->setItemList($list)
            ->setDescription('Abonnement sur fasfoot.com')
            ->setAmount($amount);
        if($request->newAbn=='false'){
            $transaction->setCustom($abnInfo->typeab_id.'|'.$teamId.'|'.$abnInfo->typerab_hoursamount.'|'.$abnInfo->typeab_duration.'|'.$oldAbn->abn_end);
        }else{
            $transaction->setCustom($abnInfo->typeab_id.'|'.$teamId.'|'.$abnInfo->typerab_hoursamount.'|'.$abnInfo->typeab_duration);
        }
            

        $payment = new \PayPal\Api\Payment();
        $payment->setTransactions([$transaction]);

        $payment->setIntent('sale');

        $redirectUrls = (new \PayPal\Api\RedirectUrls())
            ->setReturnUrl('http://localhost:8000/payEx')
            ->setCancelUrl('http://localhost:8000/');

        $payment->setRedirectUrls($redirectUrls);

        $payment->setPayer((new \PayPal\Api\Payer())->setPaymentMethod('paypal'));
        
        $flowConfig = new \PayPal\Api\FlowConfig();
        
        $flowConfig->setLandingPageType("Billing");
        
        $presentation = new \PayPal\Api\Presentation();
        
        $presentation->setBrandName("Fast Foot!")
        
            ->setLocaleCode("FR")
            ->setReturnUrlLabel("Retour")
            ->setNoteToSellerLabel("Merci !");
        
        $inputFields = new \PayPal\Api\InputFields();
        
        $inputFields->setAllowNote(true)
            ->setNoShipping(1)
            ->setAddressOverride(0);

        $webProfile = new \PayPal\Api\WebProfile();

        $webProfile->setName("Fast Foot !" . uniqid())
            ->setFlowConfig($flowConfig)
            ->setPresentation($presentation)
            ->setInputFields($inputFields)
            ->setTemporary(true);
            
        try{
            $createProfileResponse = $webProfile->create($apiContext);

            $payment->setExperienceProfileId($createProfileResponse->id);

            $payment->create($apiContext);
            return $payment->getApprovalLink();
        }catch(\PayPal\Exception\PayPalConnectionException $e){
            return  $e->getData();
        }
        
    }

    public function payEx(){

        $ids = require('paypalConfig.php');

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $ids['id'],
                $ids['secret']
            )
        );
        
        $payment = \PayPal\Api\Payment::get($_GET['paymentId'],$apiContext);

        $execution = (new \PayPal\Api\PaymentExecution())
            ->setPayerId($_GET['PayerID'])
            ->setTransactions($payment->getTransactions());

        try{

            $payment->execute($execution,$apiContext);

            $abnInfo = explode("|",$payment->getTransactions()['0']->getCustom());

            if(count($abnInfo)==4){
                $abnQuery = DB::insert("insert into abonnements(typeab_id,team_id,abn_start,abn_end,abn_remaininghours)  values(".$abnInfo['0'].",".$abnInfo['1'].",date(now()),date(CURRENT_DATE + INTERVAL ".$abnInfo['3']." DAY),".$abnInfo['2'].")");
            }else{
                $abnQuery = DB::insert("insert into abonnements(typeab_id,team_id,abn_start,abn_end,abn_remaininghours)  values(".$abnInfo['0'].",".$abnInfo['1'].",date(date('".$abnInfo['4']."') + INTERVAL 1 DAY),date(date('".$abnInfo['4']."')+1 + INTERVAL ".$abnInfo['3']." DAY),".$abnInfo['2'].")");
            }

            return redirect('/');


        }catch(\PayPal\Exception\PayPalConnectionException $e){

            return $e->getData();

        }        
    }

    public function getInvits(Request $request){
        $team = DB::select("select *,quartier_name_fr from teams join quartiers on teams.quartier_id = quartiers.quartier_id where team_email='".session('email')."'");
        $invits = DB::select("select * from matches where date(now())<=date(match_end) and hour(now())<hour(match_end) and guestteam_id=".$team['0']->team_id." and accept=0");
        $accept = DB::select("select * from matches where date(now())<=date(match_end) and hour(now())<hour(match_end) and hostteam_id=".$team['0']->team_id." and accept=1");
        $teams = DB::select("select * from teams");
        return ['invits'=>$invits,'teams'=>$teams,'accept'=>$accept];
    }

    public function cancelInv (Request $request){
        $query = DB::update("update matches set guestteam_id=null where match_id=".$request->id);
    }
    
    public function approvInv(Request $request){
        $update = DB::update("update matches set accept='1' where match_id=".$request->id);
    }
}
