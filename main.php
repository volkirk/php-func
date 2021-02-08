<?php //php 7.2.24

$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

function getPartsFromFullname($fullName)
{
    $fullNameArr= explode(' ', $fullName);
    $fullNameArr['surname']=$fullNameArr['0'];
    $fullNameArr['name']=$fullNameArr['1'];
    $fullNameArr['patronomic']=$fullNameArr['2'];
    unset($fullNameArr[0]);
    unset($fullNameArr[1]);
    unset($fullNameArr[2]);
    return ($fullNameArr);
}

function getFullNameFromParts($secN,$firstN,$midN)
{
   return $secN .' '. $firstN . ' ' . $midN ;
}

function getShortName($name)
{
    $arr=getPartsFromFullname($name);
    $firstN=$arr['name'];
    $secN=$arr['surname'];
    $shortSecN=mb_substr($secN,0,1);
    return $firstN . ' '. $shortSecN.'.';
}

function getGenderFromName($name)
{
    
    $arr=getPartsFromFullname($name);
    $sex=0;
    $firstN=$arr['name'];
    $secN=$arr['surname'];
    $thirdN=$arr['patronomic'];
    $strLenSec=(strlen($secN)/2)-1;
    $strLenName=(strlen($firstN)/2)-1;
    $strLenThird=(strlen($thirdN)/2)-1;
    $lastS=mb_substr($firstN, $strLenName,1);
    $last3=mb_substr($thirdN, $strLenThird-2,3);
    $last2=mb_substr($secN, $strLenSec-1,2);
    $last2Third=mb_substr($thirdN,$strLenThird-1,2);
    $lastSurS=mb_substr($secN, $strLenSec, 1);
    if ($lastS=='а')
    {
        $sex--;
    }
    if ($last2=='ва')
        $sex--;
    if ($last3=='вна')
        $sex--;
    if ($lastS=='й')
        $sex++;
    if ($lastS=='н')
        $sex++;
    if ($lastSurS=='в')
        $sex++;
    if (($last3=='ичь')||($last2Third=='ич'))
        $sex++;
    if ($sex>0)
        $sex=1;
    if ($sex<0)
        $sex=-1;
    
    return $sex;
}

function getGenderDiscription($arr)
{
    $mujic=0;
    $jenshina=0;
    $nuetral=0;
    $i=0;
    $arrLeng=count($arr);

    echo '/'. $arrLeng .' - длинна массива/';
    for ($i=0;$i<$arrLeng;$i++)
    {
        $sex=getGenderFromName($arr[$i]['fullname']);
        if ($sex>0)
            $mujic++;
        if ($sex==0)
            $nuetral++;
        if ($sex<0)
            $jenshina++;
    }
    echo '/Мужчин: '. round((100/$arrLeng*$mujic),1) . '% / ';
    echo '/Женщин: '. round((100/$arrLeng*$jenshina),1) . '% / ';
    echo '/Неопределенно: '. round((100/$arrLeng*$nuetral),1) . '% / ';
}

function getPerfectPartner ($firstN, $secN, $thirdN, $arr)
{
    $firstN=ucfirst($firstN);
    $secN=ucfirst($secN);
    $thirdN=ucfirst($thirdN);
    $name=getFullNameFromParts($firstN,$secN,$thirdN);
    $sex=getGenderFromName($name);
    $arrLeng=count($arr);
    $randInt=rand(0, $arrLeng);
    if (getGenderFromName($arr[$randInt]['fullname'])!=$sex)
    {   echo getShortName($name) . '+' . getShortName($arr[$randInt]['fullname']) . ' = ';
        echo rand(50,100) . '%(сердце)';
    }

    
}

 print_r (getPartsFromFullname($example_persons_array['0']['fullname']));
echo "\n";
 echo (getFullNameFromParts('Дудь','Юра','Будет'));
echo "\n";
echo (getShortName('Иванов Иван Иванович'));
echo "\n";
echo (getGenderFromName('Волкова Александра Семеновна'));
echo "\n";
echo (getGenderDiscription($example_persons_array));
echo "\n";
getPerfectPartner('Шегова', 'Кристина', 'Ивановна', $example_persons_array);

    
?>