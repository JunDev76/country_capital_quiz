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
        '가나' => '아크라',
        '가봉' => '리브르빌',
        '가이아나' => '조지타운',
        '감비아' => '반줄',
        '괌' => '하갓냐',
        '과테말라' => '과테말라',
        '그레나다' => '세인트조지스',
        '그리스' => '아테네',
        '그린랜드' => '누크',
        '기니' => '코나크리',
        '기니비사우' => '비사우',
        '나미비아' => '빈트후크',
        '나우루' => '야렌',
        '나이지리아' => '아부자',
        '남수단' => '주바',
        '남아프리카 공화국' => '프리토리아, 블룸폰테인, 케이프타운',
        '남오세티야' => '츠힌발리',
        '네덜란드' => '암스테르담',
        '네팔' => '카트만두',
        '노르웨이' => '오슬로',
        '뉴질랜드' => '웰링턴',
        '니우에' => '알로피',
        '니제르' => '니아메',
        '니카라과' => '마나과',
        '대한민국' => '서울',
        '덴마크' => '코펜하겐',
        '도미니카' => '로조',
        '도미니카 공화국' => '산토도밍고',
        '독일' => '베를린',
        '동티모르' => '딜리',
        '라오스' => '비엔티안',
        '라이베리아' => '몬로비아',
        '라트비아' => '리가',
        '러시아' => '모스크바',
        '레바논' => '베이루트',
        '레소토' => '마세루',
        '루마니아' => '부쿠레슈티',
        '룩셈부르크' => '룩셈부르크',
        '르완다' => '키갈리',
        '리비아' => '트리폴리',
        '리투아니아' => '빌뉴스',
        '리히텐슈타인' => '파두츠',
        '마다가스카르' => '안타나나리보',
        '마셜 제도' => '마주로',
        '마케도니아 공화국' => '스코페',
        '말라위' => '릴롱궤',
        '말레이시아' => '쿠알라룸푸르, 푸트라자야',
        '말리' => '바마코',
        '멕시코' => '멕시코시티',
        '모나코' => '모나코',
        '모로코' => '라바트, 카사블랑카',
        '모리셔스' => '포트루이스',
        '모리타니' => '누악쇼트',
        '모잠비크' => '마푸투',
        '몬테네그로' => '포드고리차',
        '몰도바' => '키시너우',
        '몰디브' => '말레',
        '몰타' => '발레타',
        '몽골' => '울란바토르',
        '미국' => '워싱턴 D.C.',
        '미얀마' => '네피도',
        '미크로네시아 연방' => '팔리키르',
        '바누아투' => '포트빌라',
        '바레인' => '마나마',
        '바베이도스' => '브리지타운',
        '바티칸 시국' => '바티칸',
        '바하마' => '나소',
        '방글라데시' => '다카',
        '베냉' => '포르토노보',
        '베네수엘라' => '카라카스',
        '베트남' => '하노이',
        '벨기에' => '브뤼셀',
        '벨라루스' => '민스크',
        '벨리즈' => '벨리즈시티',
        '보스니아 헤르체고비나' => '사라예보',
        '보츠와나' => '가보로네',
        '볼리비아' => '라파스',
        '부룬디' => '기테가',
        '부르키나파소' => '와가두구',
        '부탄' => '팀푸',
        '북키프로스' => '니코시아',
        '불가리아' => '소피아',
        '브라질' => '브라질리아',
        '브루나이' => '반다르스리브가완',
        '사모아' => '아피아',
        '사우디아라비아' => '리야드',
        '사하라 아랍 민주 공화국' => '엘아이운',
        '산마리노' => '산마리노',
        '상투메 프린시페' => '상투메',
        '세네갈' => '다카르',
        '세르비아' => '베오그라드',
        '세이셸' => '빅토리아',
        '세인트루시아' => '캐스트리스',
        '세인트빈센트 그레나딘' => '킹스타운',
        '세인트키츠 네비스' => '바스테르',
        '소말리아' => '모가디슈',
        '소말릴란드' => '하르게이사',
        '솔로몬 제도' => '호니아라',
        '수단' => '하르툼',
        '수리남' => '파라마리보',
        '스리랑카' => '스리자야와르데네푸라코테',
        '스웨덴' => '스톡홀름',
        '스위스' => '베른',
        '스페인' => '마드리드',
        '슬로바키아' => '브라티슬라바',
        '슬로베니아' => '류블랴나',
        '시리아' => '다마스쿠스',
        '시에라리온' => '프리타운',
        '싱가포르' => '싱가포르',
        '아랍에미리트' => '아부다비, 두바이',
        '아르메니아' => '예레반',
        '아르차흐 공화국' => '스테파나케르트',
        '아르헨티나' => '부에노스아이레스',
        '아이슬란드' => '레이캬비크',
        '아이티' => '포르토프랭스',
        '아일랜드' => '더블린',
        '아제르바이잔' => '바쿠',
        '아프가니스탄' => '카불',
        '안도라' => '안도라라베야',
        '알바니아' => '티라나',
        '알제리' => '알제',
        '압하지야' => '수후미',
        '앙골라' => '루안다',
        '앤티가 바부다' => '세인트존스',
        '에리트레아' => '아스마라',
        '에스와티니' => '음바바네, 로밤바',
        '에스토니아' => '탈린',
        '에콰도르' => '키토, 과야킬',
        '에티오피아' => '아디스아바바',
        '엘살바도르' => '산살바도르',
        '영국' => '런던',
        '예멘' => '사나',
        '오만' => '무스카트',
        '오스트레일리아' => '캔버라',
        '오스트리아' => '빈',
        '온두라스' => '테구시갈파',
        '요르단' => '암만',
        '우간다' => '캄팔라',
        '우루과이' => '몬테비데오',
        '우즈베키스탄' => '타슈켄트',
        '우크라이나' => '키예프',
        '웨일즈' => '카디프',
        '이라크' => '바그다드',
        '이란' => '테헤란',
        '이스라엘' => '텔아비브',
        '이집트' => '카이로',
        '이탈리아' => '로마',
        '인도' => '뉴델리, 뭄바이',
        '인도네시아' => '자카르타',
        '일본' => '도쿄',
        '자메이카' => '킹스턴',
        '잠비아' => '루사카',
        '적도 기니' => '말라보',
        '조선민주주의인민공화국' => '평양직할시',
        '조지아' => '트빌리시',
        '중앙아프리카 공화국' => '방기',
        '중화민국' => '타이베이',
        '중화인민공화국' => '베이징',
        '지부티' => '지부티',
        '짐바브웨' => '하라레',
        '차드' => '은자메나',
        '체코' => '프라하',
        '칠레' => '산티아고',
        '카메룬' => '야운데',
        '카보베르데' => '프라이아',
        '카자흐스탄' => '누르술탄',
        '카타르' => '도하',
        '캄보디아' => '프놈펜',
        '캐나다' => '오타와',
        '케냐' => '나이로비',
        '코모로' => '모로니',
        '코소보' => '프리슈티나',
        '코스타리카' => '산호세',
        '코트디부아르' => '야무수크로',
        '콜롬비아' => '보고타',
        '콩고 공화국' => '브라자빌',
        '콩고 민주 공화국' => '킨샤사',
        '쿠바' => '아바나',
        '쿠웨이트' => '쿠웨이트',
        '쿡 제도' => '아바루아',
        '크로아티아' => '자그레브',
        '키르기스스탄' => '비슈케크',
        '키리바시' => '타라와',
        '키프로스' => '니코시아',
        '타지키스탄' => '두샨베',
        '탄자니아' => '도도마',
        '태국' => '방콕',
        '터키' => '앙카라',
        '토고' => '로메',
        '통가' => '누쿠알로파',
        '투르크메니스탄' => '아슈하바트',
        '투발루' => '푸나푸티',
        '튀니지' => '튀니스',
        '트란스니스트리아' => '티라스폴',
        '트리니다드 토바고' => '포트오브스페인',
        '파나마' => '파나마시티',
        '파라과이' => '아순시온',
        '파키스탄' => '이슬라마바드',
        '파푸아뉴기니' => '포트모르즈비',
        '팔라우' => '응게룰무드',
        '팔레스타인' => '라말라',
        '페루' => '리마',
        '포르투갈' => '리스본',
        '폴란드' => '바르샤바',
        '푸에르토리코' => '산후안',
        '프랑스' => '파리',
        '피지' => '수바',
        '핀란드' => '헬싱키',
        '필리핀' => '마닐라',
        '헝가리' => '부다페스트',
        '호주' => '캔버라'
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
        if(strtolower(str_replace(' ', '', $answer)) === strtolower(str_replace(' ', '', $this->answer))){
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