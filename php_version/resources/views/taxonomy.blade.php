@extends('layouts.layout')

@section('append_header')
  <link rel='stylesheet' href='/css/taxonomy.css'>
@endsection

@section('headerContent')
    <header>
        <div class="header-inner">
            <div class="Logo">Barcode DB</div>
            <div class="header-item">
                <nav class="nav1">
                    <ul>
                        <li><a href="/"> Top </a></li>
                        <li><a href="/download">DownLoad</a></li>
                        <li id="now"><a href="#">Taxonomy</a></li>
                        <li><a href="/help"> Help </a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="headline">
            <h1>Taxonomy</h1>
            <h3>You can check what kind of species or genus are included in each DataBase, <br> directly by watching the
                List or by searching them from the family List.</h3>
        </div>
        <div class="section_wrap">
            <section>
                <div class="option">
                    <p class="attention">Please select one of the options.
                        By default,Family list are shown below.</p>
                    <group>
                        <p class="opt"><input id="box1" type="radio" name="cat" onchange="Listshow('first')"
                                checked="checekd"><label class="cate">family</label></p>
                        <p class="opt"><input id="box2" type="radio" name="cat" onchange="Listshow('second')"><label
                                class="cate">genus</label></p>
                        <p class="opt"><input id="box3" type="radio" name="cat" onchange="Listshow('third')"><label
                                class="cate">species</label></p>
                    </group>
                </div>
                <ul id="ulaccordion" class="accordion first">
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">A</p><button type="button" onclick="Jump('A')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">B</p><button type="button" onclick="Jump('B')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">C</p><button type="button" onclick="Jump('C')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">D</p><button type="button" onclick="Jump('D')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">E</p><button type="button" onclick="Jump('E')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">F</p><button type="button" onclick="Jump('F')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">G</p><button type="button" onclick="Jump('G')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">H</p><button type="button" onclick="Jump('H')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">I</p><button type="button" onclick="Jump('I')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">J</p><button type="button" onclick="Jump('J')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">K</p><button type="button" onclick="Jump('K')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">L</p><button type="button" onclick="Jump('L')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">M</p><button type="button" onclick="Jump('M')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">N</p><button type="button" onclick="Jump('N')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">O</p><button type="button" onclick="Jump('O')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">P</p><button type="button" onclick="Jump('P')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">Q</p><button type="button" onclick="Jump('Q')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">R</p><button type="button" onclick="Jump('R')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">S</p><button type="button" onclick="Jump('S')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">T</p><button type="button" onclick="Jump('T')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">U</p><button type="button" onclick="Jump('U')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">V</p><button type="button" onclick="Jump('V')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">W</p><button type="button" onclick="Jump('W')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">X</p><button type="button" onclick="Jump('X')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">Y</p><button type="button" onclick="Jump('Y')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">Z</p><button type="button" onclick="Jump('Z')">Show the List</button>
                        </div>
                    </li>
                    <li class="alpha">
                        <div class="wrap_header">
                            <p class="header">Other</p><button type="button" onclick="Jump('Other')">Show the
                                List</button>
                        </div>
                    </li>
                    <li class="alpha"></li>
                </ul>
            </section>
        </div>
    </main>

    <script type="text/javascript">buList = document.getElementsByTagName('button');
        for (var k = 0; k < buList.length; k++) {
            buList[k].addEventListener('mouseenter', function () {
                color = this.style.backgroundColor;
                temp = "";	//initialize;
                temp = color;
                this.style.backgroundColor = '#ff8b5f';
                this.style.boxShadow = '0 0px 2px #525f718c, 0 -4px 5px -2px #262c358f inset';
            }, false);
            buList[k].addEventListener('mouseleave', function () {
                this.style.backgroundColor = temp;
                this.style.boxShadow = "";
            }, false);
        }
        function Listshow(acnum) {
            fade = document.getElementById('ulaccordion');
            pa = fade.parentNode;
            fade.classList.remove('first');
            fade.classList.add('select_move');
            fade.parentNode.removeChild(fade);
            pa.appendChild(fade);
            cL = document.getElementsByClassName('wrap_header');
            //acnum = qw/ph ge sp/;
            for (var i = 0; i < cL.length; i++) {
                if (acnum == 'first') {
                    cL[i].style.backgroundColor = '#a4d4c6';
                    cL[i].children[1].style.backgroundColor = '#149298';
                } else if (acnum == 'second') {
                    cL[i].style.backgroundColor = '#149298';
                    cL[i].children[1].style.backgroundColor = 'orange';
                } else if (acnum == 'third') {
                    cL[i].style.backgroundColor = '#0a799a';
                    cL[i].children[1].style.backgroundColor = '#FFC107';
                }
            }
        };
        function Jump(alp) {
            //which category one of three.;
            rad = document.getElementsByName('cat');
            for (var i = 0; i < rad.length; i++) {
                if (rad[i].checked == true) {
                    category = rad[i].nextElementSibling.innerHTML;
                    break;
                } else {
                    //pass;
                }
            }
            if (alp == 'Other') {
                alp = 'x';
            }
            location.href = `./taxonomy/${category}/${alp}`;
            /*
            if(category == 'Family'){
            location.href=`./Tax_fam/${alp}`;
            }else if(category == 'Genus'){
            location.href=`./Tax_ge/${alp}`;
            }else if(category == 'Species'){
            location.href=`./Tax_sp/${alp}`;
            }
            */
        }</script>
@endsection
