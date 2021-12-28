<?php

/*
       _             _____           ______ __
      | |           |  __ \         |____  / /
      | |_   _ _ __ | |  | | _____   __ / / /_
  _   | | | | | '_ \| |  | |/ _ \ \ / // / '_ \
 | |__| | |_| | | | | |__| |  __/\ V // /| (_) |
  \____/ \__,_|_| |_|_____/ \___| \_//_/  \___/


This program was produced by JunDev76 and cannot be reproduced, distributed or used without permission.

Developers:
 - JunDev76 (https://github.jundev.me/)

Copyright 2021. JunDev76. Allrights reserved.
*/

namespace JunDev76\country_capital_quiz;

use Exception;
use JUN\Jsoundapi;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;

class country_capital_quiz extends PluginBase implements Listener{

    use SingletonTrait;

    public function onLoad() : void{
        self::setInstance($this);
    }

    public array $capitals_only_country = [];
    public array $capitals = [
        "한국" => "서울",
        "쿠웨이트" => "쿠웨이트",
        "캄보디아" => "프놈펜",
        "말레이시아" => "쿠알라룸푸르",
        "미얀마" => "양곤",
        "부탄" => "팀부",
        "이라크" => "바그다드",
        "오만" => "무스카스",
        "몽골" => "울란바토르",
        "라오스" => "비엔티안",
        "아르메니아" => "예레반",
        "예멘" => "사나",
        "카타르" => "도하",
        "타지키스탄" => "두샨베",
        "미국" => "워싱톤",
        "과테말라" => "과테말라",
        "엘살바도르" => "산살바도르",
        "파나마" => "파나마",
        "바하마" => "나소",
        "아이티" => "포르트프랭스",
        "콜롬비아" => "보고타",
        "수리남" => "파르나이바",
        "볼리비아" => "라파스",
        "아르헨티나" => "부에노스아이레스",
        "이집트" => "카이로",
        "모로코" => "라바트",
        "갬비아" => "반줄",
        "라이베리아" => "몬로비아",
        "부르키나파스" => "와가두구",
        "토고" => "로메",
        "차드" => "엔자메나",
        "르완다" => "키칼리",
        "코모로" => "모로니",
        "세이셀" => "빅토리아",
        "가봉" => "리브르빌",
        "콩고민주공화국" => "킨샤샤",
        "보츠와나" => "가보로네",
        "레소트" => "마세루",
        "튀지니" => "튀니스",
        "마다가스카르" => "안타나나리보",
        "소말리아" => "모가디슈",
        "영국" => "런던",
        "오스트리아" => "빈",
        "스페인" => "마드리드",
        "그리스" => "아테네",
        "폴란드" => "바르샤바",
        "룩셈부르크" => "룩셈부루크",
        "아이스랜드" => "레이캬비크",
        "우크라이나" => "키에프",
        "알바니아" => "티라나",
        "리투아니아" => "빌뉴스",
        "벨로루시" => "민스크",
        "슬로바키아" => "브라티슬라바",
        "에스토니아" => "탈린",
        "키프로스" => "니코시아",
        "오스트렐리아" => "캔버라",
        "피지" => "수바",
        "키리바티" => "바이리키",
        "솔로몬" => "호니아라",
        "중국" => "베이징",
        "필리핀" => "마닐라",
        "베트남" => "하노이",
        "인도네시아" => "자카르타",
        "스리랑카" => "콜롬보",
        "몰디브" => "몰레",
        "사우디아라비아" => "리야드",
        "이스라엘" => "예루살렘",
        "레바논" => "베이루트",
        "그루지야" => "트빌리시",
        "바레인" => "마나마",
        "시리아" => "다마스쿠스",
        "아제르바이잔" => "바쿠",
        "우즈베키스탄" => "타슈켄트",
        "키르기스스탄" => "비슈케크",
        "투르크메니스탄" => "아슈하바트",
        "캐나다" => "오타와",
        "벨리즈" => "벨모판",
        "니카라과" => "마나구아",
        "쿠바" => "아나바",
        "그레나다" => "세인트조지스",
        "도미니카" => "산토도밍고",
        "트리니다드토바고" => "포오트오브스페인",
        "베네주엘라" => "카라카스",
        "에콰도르" => "키토",
        "브라질" => "브라질리아",
        "우루과이" => "몬테비데오",
        "리비아" => "트리폴리",
        "모리타니" => "누악쇼트",
        "기니비사우" => "비사우",
        "코트디부아르" => "야무스크로",
        "말리" => "바마코",
        "베넹" => "포르토노보",
        "수단" => "하르툼",
        "케냐" => "나이로비",
        "말라가시" => "안타나나리보",
        "모잠비크" => "마푸토",
        "앙골라" => "루안다",
        "상투메메프린시페" => "사웅투메",
        "중앙아프리카" => "방기",
        "나미비아" => "빈트후크",
        "남아프리카" => "프리토리아",
        "적도기니" => "말라보",
        "모리셔스" => "포트루이스",
        "잠비아" => "루사카",
        "프랑스" => "파리",
        "스위스" => "베른",
        "포르투칼" => "리스본",
        "루마니아" => "부쿠레슈티",
        "벨기에" => "브뤼셀",
        "덴마크" => "코펜하겐",
        "그루지아" => "트빌리지",
        "러시아" => "모스크바",
        "몰도바" => "키시네프",
        "보스니아" => "사라예보",
        "슬로베니아" => "류블랴나",
        "에스파냐" => "마드리드",
        "핀란드" => "헬싱키",
        "뉴질랜드" => "웰링턴",
        "서사모아" => "아피아",
        "나우루" => "우아보에",
        "파푸아뉴기니" => "포트모르즈니",
        "일본" => "도쿄",
        "타이" => "방콕",
        "싱가포르" => "싱가포르",
        "브루나이" => "반다르세리베가완",
        "인도" => "뉴델리",
        "파키스탄" => "이슬라마바드",
        "이란" => "테헤란",
        "예맨" => "사나",
        "요르단" => "암만",
        "터키" => "앙카라",
        "네팔" => "카트만두",
        "방글라데시" => "다카",
        "아랍에미리트" => "아부다비",
        "아프카니스탄" => "카불",
        "카자흐스탄" => "알마티",
        "타이완" => "타이베이",
        "멕시코" => "멕시코시티",
        "온두라스" => "데구시갈파",
        "코스타리카" => "산호세",
        "자메이카" => "킹스턴",
        "바베이도즈" => "브리지타운",
        "앤티기바스타" => "로조우",
        "파라과이" => "아순시온",
        "가이아나" => "조지타운",
        "페루" => "리마",
        "칠레" => "산티아고",
        "알제리" => "알제",
        "세네갈" => "다카르",
        "시에라이온" => "프리이타운",
        "가나" => "아크라",
        "니제르" => "니아메",
        "나이지리아" => "아부자",
        "에티오피아" => "아디스아바바",
        "우간다" => "캄팔라",
        "탄자니아" => "다르에르살람",
        "모리시어스" => "포트루이스",
        "말라위" => "릴롱레",
        "콩고공화국" => "브라자빌",
        "카메룬" => "야운데",
        "짐바브웨" => "하라레이",
        "스와질란드" => "므바반",
        "카보베르데" => "프라이야",
        "레소토" => "마세루",
        "부룬디" => "부줌부라",
        "지부티" => "지부티",
        "독일" => "베르린",
        "네덜란드" => "암스테르담",
        "이탈리아" => "로마",
        "체코" => "프라하",
        "유고슬라비아" => "베오그라드",
        "에이레" => "더블린",
        "노르웨이" => "오슬로",
        "불가리아" => "소피아",
        "라트비아" => "리가",
        "몰타" => "발레타",
        "스웨덴" => "스톡홀름",
        "아일랜드" => "더블린",
        "크로아티아" => "자그레브",
        "헝가리" => "부다페스트",
        "통가" => "누쿠알로파",
        "투발루" => "푸나푸티",
        "비누아투" => "포트빌라"
    ];

    public function onEnable() : void{
        $cmd = new PluginCommand("수도퀴즈다시내기", $this);
        $cmd->setDescription("수도 퀴즈를 다시 냅니다");
        $cmd->setPermission("op");
        $this->getServer()->getCommandMap()->register($this->getDescription()->getName(), $cmd);

        $capitals_only_country = [];
        foreach($this->capitals as $country => $capital){
            $capitals_only_country[] = $country;
        }
        $this->capitals_only_country = $capitals_only_country;

        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(function() : void{
            $this->getScheduler()->scheduleRepeatingTask(new ClosureTask(function() : void{
                $this->gameStart();
            }), 20 * 60 * 3);
        }), 20 * (60 * 1.5));

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * @throws Exception
     */
    public function gameStart() : void{
        $this->game = null;
        $this->title = "";

        $title = $this->capitals_only_country[random_int(0, count($this->capitals_only_country) - 1)];
        $title = preg_replace("/[#\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $title);
        $title = trim($title);

        $this->money = random_int(1000, 5000);
        $korean_money = EconomyAPI::getInstance()->koreanWonFormat($this->money);

        Server::getInstance()->broadcastMessage("§a§l[수도퀴즈] §r§f수도 퀴즈를 시작합니다! 정답을 맞추실땐 §a%§f를 붙이고 §a{$title}§f 나라의 수도를 입력해주세요! §f보상: §a$korean_money §r§o§7(예: %제주)");

        $this->game = true;
        $this->title = $title;
        $this->answer = $this->capitals[$title];
    }

    private ?bool $game = null;
    private string $title = '';
    private string $answer = '';
    private int $money = 0;

    public function standup(Player $player, $answer) : void{
        if(strtolower($answer) === strtolower($this->answer)){
            Server::getInstance()->broadcastMessage("§a§l[수도퀴즈] §r§a{$player->getName()}§f님 §a정답!§f! 게임 종료! 정답 : §a" . $this->answer);
            EconomyAPI::getInstance()->addMoney($player, $this->money);
            Jsoundapi::playsound($player, "random.levelup");
            $this->game = null;
            $this->title = '';
            $this->answer = '';
        }else{
            $player->sendMessage("§a§l[수도퀴즈] §r§f오답입니다. §a{$this->title}§f 나라의 수도를 입력해주세요.");
            Jsoundapi::playsound($player, "note.bass");
        }
    }

    /**
     * @throws Exception
     */
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($sender->isOp() && $command->getName() === "수도퀴즈다시내기"){
            $this->gameStart();
        }
        return true;
    }

    public function onChat(PlayerChatEvent $ev) : void{
        $player = $ev->getPlayer();

        if($this->game !== null){
            $message = $ev->getMessage();
            $messages = $message[0];
            if($messages === "%"){
                $ev->setCancelled();
                $this->standup($player, mb_substr($ev->getMessage(), 1, null, "UTF-8"));
            }
        }
    }

}
