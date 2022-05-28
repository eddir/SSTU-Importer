<?php

namespace Tests\mock;

class HtmlMock
{

    const RAW_HTML = <<<EOD
<!DOCTYPE HTML>
<html>
    <head>
    <meta title="testing 123..."/>
</head>
<body>
<h1>Title for blank html page</h1>
<div>
<p>Hello</p>
<p id="world">world</p>
</div>
</body>
</html>
EOD;

    const SSTU_HOMEPAGE_HTML = <<<EOD
<html lang="ru"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Расписание занятий СГТУ</title>
    <link href="/assets/css/styles.css?1640172575" type="text/css" rel="stylesheet">
</head>
<body class="rasp">

<main>
    <div class="container">
        <div class="row">
            <div class="col-6">
                            </div>
            <div class="col-6 text-right">
                <ul class="page-menu">
                                    </ul>
            </div>
        </div>

<div class="rasp-period">Второй семестр 2021/2022 учебного года</div>
<div class="rasp-date">Сегодня, 28 мая</div>


        
    <div class="rasp-block">
    <div class="block-title">Студентам</div>
    <div class="accordion rasp-structure" id="raspStructure">
                                    <div class="card">
                    <div class="card-header" id="heading196">
                        <div class="institute" data-toggle="collapse" data-target="#collapse196" aria-expanded="true" aria-controls="collapse196">
                            Институт машиностроения, материаловедения и транспорта                        </div>
                    </div>
                    <div id="collapse196" class="collapse show" aria-labelledby="heading196" data-parent="#raspStructure" style="">
                        <div class="card-body">
                                                            <div class="edu-form">Очная</div>
                                                                    <div class="group-type">Бакалавриат</div>
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                АТПП                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/303">б-АТПП-11</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/71">б-АТПП-21</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/72">б-АТПП-31</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                ЛАЗР                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/153">б2-ЛАЗР-11</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/154">б2-ЛАЗР-21</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/424">б2-ЛАЗР-31</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                                                        <div class="group-type">Магистратура</div>
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                БИСТ                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/342">м-БИСТ-11</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                КТОП                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/343">м-КТОП-11</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                АТПП                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/473">м2-АТПП-11</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                                                        <div class="group-type">Специалитет</div>
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                НТС                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/114">с-НТС-11</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/264">с-НТС-21</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/369">с-НТС-31</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/265">с-НТС-41</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                ПТК                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/273">с-ПТК-11</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/274">с-ПТК-21</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/318">с-ПТК-31</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/117">с-ПТК-41</a></div>
                                                                                                            <div class="col-auto group"><a href="/rasp/group/438">с-ПТК-51</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                                                                                <div class="edu-form">Очно-заочная</div>
                                                                    <div class="group-type">Магистратура</div>
                                                                            <div class="row groups">
                                                                                        <div class="col-auto group-start d-none d-md-block">
                                                КТОП                                            </div>
                                            <div class="col">
                                                <div class="row no-gutters">
                                                                                                            <div class="col-auto group"><a href="/rasp/group/589">м-КТОПоз-11</a></div>
                                                                                                    </div>
                                            </div>
                                        </div>
                                                                                                                        </div>
                    </div>
                </div>
                                                
                                                
                                                
                                                
                                                
                                                
                                                                                        
                        </div>
</div>

<div class="rasp-block">
    <div class="block-title">Научно-исследовательская работа магистрантов (НИР)</div>
            <div class="accordion rasp-structure" id="raspNir">
                    <div class="card">
                <div class="card-header" id="headingNir141">
                    <div class="institute collapsed" data-toggle="collapse" data-target="#collapseNir141" aria-expanded="true" aria-controls="collapseNir141">
                        Заочная                    </div>
                </div>
                <div id="collapseNir141" class="collapse" aria-labelledby="headingNir141" data-parent="#raspNir">
                    <div class="card-body">
                                                    <div class="mb-1"><a href="/files/nir/npr_z_19.docx" class="file">Институт машиностроения, материаловедения и транспорта</a></div>
                                                    <div class="mb-1"><a href="/files/nir/npr_z_18.docx" class="file">Институт урбанистики, архитектуры и строительства</a></div>
                                                    <div class="mb-1"><a href="/files/nir/npr_z_15.docx" class="file">Институт прикладных информационных технологий и коммуникаций</a></div>
                                                    <div class="mb-1"><a href="/files/nir/npr_z_17.docx" class="file">Институт энергетики</a></div>
                                                    <div class="mb-1"><a href="/files/nir/npr_z_14.docx" class="file">Институт социального и производственного менеджмента</a></div>
                                                    <div class="mb-1"><a href="/files/nir/npr_z_10.docx" class="file">Институт электронной техники и приборостроения</a></div>
                                                    <div class="mb-1"><a href="/files/nir/npr_z_20.docx" class="file">Социально-экономический институт</a></div>
                                            </div>
                </div>
            </div>
                </div>
    </div>
            </div>
        </main>
        
           
    
</body></html>
EOD;
}