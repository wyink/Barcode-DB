@extends('layouts.layout')

@section('append_header')
  <link rel='stylesheet' href='/css/web.css'>
  <link rel='stylesheet' href='/css/form.css'>
@endsection

@section('headerContent')
  <header>
    <div class="header-inner">
      <div class="Logo">Barcode DB</div>
      <div class="header-item">
        <nav class="nav1">
          <ul>
            <li id="now">
              <a href='/'> Top </a>
            </li>
            <li>
              <a href='/download'> DownLoad </a>
            </li>
            <li>
              <a href='/taxonomy'> Taxonomy </a>
            </li>
            <li>
              <a href='/help'> Help </a>
            </li>
          </ul>    
        </nav>
      </div>
    </div>
    <div class="foot">
      <div class="wrap">
        <h1> What is Barcode DB? </h1>
      </div>
      <div class="main_b_wrap">
        <div class="explain">
          <div class="exp_in">
            <span class="span_1">D</span>
            NA barcoding is a method for species identification.
            We offer some original curated Database for DNA barcoding.
            <br>
            You can identify a sequence every one submit on this website.
            In addition, we offer a tool for identifying large amount of sequences.
            <br>
          </div>
          <div class="appeal_wrap">
            <div>
              <a id="skip" onclick='Onskip();'>
                Identify
                <p> Run on this website</p>
            </div>
            <div>
              <a onclick='Onskip_2();'>
                Curated Database
                <p>Show details</p>
            </div>
            <div>
              <a>
                Identify
                <p>
                  Run with a pipeline tool
                  <br>
                  (Under construction)
                </p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
@endsection

@section('main')
  <main id="identification">
    <div class="form">
      <h2 id="a01" class="middle">Identification</h2>
      <form id="form1">
        <h3 class="db_nav">
          <span class="num">1.</span>
          " Select the database
        </h3>
        <div class="data_wrap">
          <div class="op_gene">Select the gene you have.</div>
          <group class="f_radio">
            <div class="f_option">
              <input id="f1_a" class="fra" type='radio' name='gene' checked='checked' onchange='Radiochange();'>
              <label class="fla">rbcL</label>
            </div>
            <div class="f_option">
              <input> id="f1_b" class="fra" type='radio' name='gene' onchange='Radiochange();'>
              <label class="fla">matK</label>
            </div>
            <p id="r1"> ribulose 1,5-bisphosphatecarboxylase/oxygenase large subunit</p>
          </group>
          <div class="op_db"> Select the database you want submit to.</div>
          <group class="f_radio">
            <div class="f_option">
              <input id="f2_a" class="fra" type='radio' name='data' checked='checked' onchange='Radiochange();'>
              <label class="fla">Curated</label>
            <div class="f_option">
              <input id="f2_b" class="fra" type='radio' name='data' onchange='Radiochange();'>
              <label class="fla">ALL</label>
            </div>
          <p id="r2">The Database curated by conserved domain/featues site</p>
          </group>
        </div>
      </form>
      <form id="cgi" action='/blastRun' method='post' onsubmit='return check()'>
        <div class="sewrap">
          <label class="Query_label" for='Query'>
            <span class="num">2.</span>
            Enter a sequence in fasta fomat
          </label>
          <div class="thrbtn">
            <div>
              <input type='radio' name='sampleGene' value='0' onclick='sample(1)'>
              clear the text
            </div>
            <div>
              <input type='radio' name='sampleGene' value='1' checked='checked' onclick='sample(2)'>
              rbcL sample
            </div>
            <div>
              <input type='radio' name='sampleGene' value='2' onclick='sample(3)'>
              matK sample
            </div>
          </div>
        </div>
        <textarea id="query" name='query' maxlength='2000' oninput='gosubmit()'>
          >sample(default --rbcL--)
          atgtcaccacaaacagagactaaagcaagtgttggattcaaagctggtgttaaagaatacaaattgacttattatactcctgactatgaaccccatgaccatgatatcttggcagcatttcgagtaactcctcaacctggagttccaccagaagaagcaggggctgcggtagctgccgaatcttctactggtacatggacaactgtgtggaccgatggacttaccagccttgatcgttacaaaggacgatgctaccacatcgagcctgttcctggcgaagaa
        <input id="sbm" type='submit' value='Submit'>
      </form>
  <div id="jumpFromHelp" class="curated">
    <h2 class="middle adj1">About the curated database</h2>
    <nav class="parent_nav">
      <li>1. source</li>
      <li>2. How to curate a number of sequences</li>
      <nav class="child_nav">
        <li>  (ⅰ) rbcL</li>
        <li>  (ⅱ) matK</li>
      <li> 3. The advantage of the database</li>
    </nav>
    <div class="1_wrap">
      <h3 class="n_1">1.source</h3>
      <p class="n_1_c">
        The original source of all of the sequences and the taxonomic infomation included in this database is National Center for Biotechnology information (NCBI).
        You can download them from the URL / ( 
        <a href='ftp://ftp.ncbi.nlm.nih.gov/genbank/'>
        ftp://ftp.ncbi.nlm.nih.gov/genbank/).
        And we also use Basic Local Alignment Search Tool (BLAST). 
        You can also download the application from the URL / ( 
        <a href='ftp://ftp.ncbi.nlm.nih.gov/blast/executables/blast+/'>
          <span class="break"> ftp://ftp.ncbi.nlm.nih.gov/blast/executables/blast+/).</span>
      </p>
    <div class="2_wrap"d>
      <h3 class="n_2">2.How to curate a number of sequences</h3>
      <div class="rb_wrap">
        <h4> 2-ⅰrbcL</h4>
        <p>
          First,we collected reference sequences (RefSeq) recorded about protein in plastid, which are provided as the Genbank Flat File Format
          <span class="break">
            <a href='ftp://ftp.ncbi.nlm.nih.gov/refseq/release/plastid/'> ftp://ftp.ncbi.nlm.nih.gov/refseq/release/plastid/</a>
          .
          RefSeq collection is a comprehensive, integrated, non-redundant, well-annotated set of sequences,so the dataset has the small amount of sequences with high accuracy. 
          The number of sequences is not enough to identify plant species accurately. For that reason, from the document, we just only abstract the location and some of the
          amino acid patterns ( 
          <sup>*1</sup>
          <span class="sup">conserved features</span>
          of 
          <sup>*2</sup>
          <span class="sup">RuBisCo_large_I</span>
          ).That has five conserved features: active site,metal binding, 
          catalytic,homodimer,heterodimer, but this time, active site,metal binding,catalytic were used to construct the main curated database to collect as many sequences as
          possible. The reason is all of the redundant sequences don't always have all the conserved features. The more accurately you want, the less sequences you can collect.That  
          leads reducing the accuracy of identification, but to those who need that, we also offer the curated database. 
          Second, we also collected all of the plant sequences from the URL / 
          span.break
          <a href='ftp://ftp.ncbi.nlm.nih.gov/genbank/'>ftp://ftp.ncbi.nlm.nih.gov/genbank/</a>
          .
          These data are redundant and also provided as a genbank format file. Third, after abstracting sequences recorded as rbcL gene, we selected all of them that has
          the previously mentioned patterns.Finally, we cut off each sequence according to the both ends of the conserved features.
        </p>
        <p class="sup_title">
          <small>
            <sup>*1</sup>
            Conserved domain/features:
          </small>
        <p class="sup_content">
          <small>
            the features conserved in the domain family such as catalytic residues, binding sites, or motifs. 
            if you want to learn more about conserved features/sites, please check
            the URL / 
            <span class="break">
              <a href='https://www.ncbi.nlm.nih.gov/Structure/cdd/cdd_help.shtml#ConservedFeatures'> https://www.ncbi.nlm.nih.gov/Structure/cdd/cdd_help.shtml
            </span>
          </small>
        </p>
        <p></p>
        <p class="sup_title">
          <small>
            <sup>*2</sup>
            RuBisCo_large_I
          </small>
        </p>
        <p class="sup_content">
          <a href='https://www.ncbi.nlm.nih.gov/Structure/cdd/cddsrv.cgi?uid=cd08212'>cd08212
          : Ribulose bisphosphate carboxylase large chain,Form I
        </p>
      <div class="ma_wrap">
        <h4>2-(ⅱ)matK</h4>
        <p>
          The way to curate the sequences encoding maturaseK is the same in the middle of 2-(i) rbcL. After we collected Refseq recorded
          about protein in plastid, we abstract the location and some of the amino acid patterns. Unlike RuBisCo_large_I , Maturase K has 
          two conserved domain: MatK_N (CDD:
          <a href='https://www.ncbi.nlm.nih.gov/Structure/cdd/cddsrv.cgi?uid=280070'>280070
          ), 
          Intron_maturas2 (CDD:
          <a href='https://www.ncbi.nlm.nih.gov/Structure/cdd/cddsrv.cgi?uid=279664'>279664
          ).
          After that,we cut off each sequence according to the both ends of the conserved domain.
        </p>
      </div>
    </div>
    <div class="wrap3">
      <h3 class="n_2">3.The advantage of database</h3>
      <p>
        1.This Database reduces False Negative.
        Conventional databases have completely different sequenences in terms of lengths.
        This point leads False Negative(FN) result when you identify species with a local alignment search tool like BLAST.
        The figure below explains how FN arises mentioned above.
      </p>
      <div class="imgwrapper">
        <p>
          img(src='/images/adv1.png' alt='Conventional Database')
        </p>
        <p>
          <img src='/images/adv2.png' alt='Our Database'>
        </p>
      <p>
        2.It provides few error for you when you analyze similarity between base sequences.
        -For example, when you align sequences and draw phylogenetic tree,you need accurate
        sequences. That is simply because its way calculate a result with the difference between
        sequences. In other words, different length of each sequences leads wrong answer. All
        sequences in this database have almost all the same length, so you don't have to care this point
        if you use this database.
      </p>
    </div>
  </div>
@endsection

@section('scripts')
  <script type='text/javascript'>
    function check(){
    te_wo = document.getElementById("query").value;
    count = document.getElementById("query").value.length;
    /*It'll return false when the length of the seq is more than 2000*/
    if(count > 2000){
    alert("too many bases");
    return false;
    }else if(count == 0){
    alert("Please enter fasta sequence");
    return false;
    }
    /*multi_sequence*/
    te_wo = te_wo.replace(/\\r?\n/g,'');
    ma=te_wo.match(/^.*>.*>.*$/);
    if(ma){
    alert("Please put one sequence at one time");
    return false;
    }
    rad=Radiochange();
    //動的に送信するフォームタグの中に送信を行わないフォームタグの
    //inputタグを埋め込み、擬似的に2つのフォームを一つのフォームと
    //して複数の値を送信する
    cr=document.getElementById('cgi');
    div1=document.createElement('input');
    div1.style.visibility='hidden';
    cr.appendChild(div1);
    div1.name = "gene" ;
    div1.value = rad[0];

    div2=document.createElement('input');
    div2.style.visibility='hidden';
    cr.appendChild(div2);
    div2.name = "db" ;
    div2.value = rad[1];

    /*return true*/
    }
    function Radiochange(){
    var up_1=document.getElementById('f1_a');
    var bo_1=document.getElementById('f2_a');
    ge="";array=[];
    db="";
    if(up_1.checked == true){
    document.getElementById('r1').innerHTML = 'ribulose 1,5-bisphosphatecarboxylase/oxygenase large subunit';
    ge='rbcL';
    }else{
    document.getElementById('r1').innerHTML = 'the trnK tRNA gene intron. Type2 intron maturase';
    ge='matK';
    }
    if(bo_1.checked == true){
    document.getElementById('r2').innerHTML = 'The Database curated by conserved domain/featues site';
    db='curated'
    }else{
    document.getElementById('r2').innerHTML = 'The redundant Database.';
    db='ALL';
    }
    array=[ge,db]
    return array;
    };
    function gosubmit(){
    ex_check = document.getElementById('query');
    btn_submit = ex_check.nextElementSibling
    if(ex_check.value == ''){
    btn_submit.style.backgroundColor = '#2c92bb';
    btn_submit.style.borderColor = 'buttonface';
    }else{
    btn_submit.style.backgroundColor = '#ff6707';
    btn_submit.style.borderColor = '#ffc107';
    }
    };
    /* element-height; */
    function Onskip(){
    fi = document.getElementsByClassName('wrap');
    fih = fi[0].clientHeight;
    se = document.getElementsByClassName('main_b_wrap');
    seh = se[0].clientHeight;
    window.scrollTo(0,fih+seh);
    }
    function Onskip_2(){
    fi = document.getElementsByClassName('wrap');
    fih = fi[0].clientHeight;
    se = document.getElementsByClassName('main_b_wrap');
    seh = se[0].clientHeight;
    th= document.getElementById('identification');
    thh=th.clientHeight;
    window.scrollTo(0,fih+seh+thh+100);
    }
    function sample(num){
    a = document.getElementsByClassName('thrbtn');
    textarea = document.getElementById('query');
    cl=a[0].children[0].style;
    rb=a[0].children[1].style;
    ma=a[0].children[2].style;
    c1='#367a8e'; c2='white';
    if(num==1){
    textarea.value = '';
    cl.backgroundColor = c1;	cl.color = c2;
    rb.backgroundColor = c2;	rb.color = c1;
    ma.backgroundColor = c2;	ma.color = c1;
    }else if(num==3){
    textarea.value = ">sample(default--matK--) \natgtatcaacagagttatttgattaattcgtttaatgattctaatccaaatcgatttgttggacacagcaatcataatcatcatttttctcaaatgatatcagggggttttgcagttattgtagaaattcctttctccctgccattttttcttgaagaaaaaaaagaaatacaaaaatatcagaatttacaatccattcattcgatattcccttttttagaggacaaattttcacatttaaattatgtgtcagatatagtaataccctatcctattcatctt";
    cl.backgroundColor = c2;	cl.color = c1;
    rb.backgroundColor = c2;	rb.color = c1;
    ma.backgroundColor = c1;	ma.color = c2;
    }else{
    textarea.value = ">sample(default--rbcL--) \natgtcaccacaaacagagactaaagcaagtgttggattcaaagctggtgttaaagaatacaaattgacttattatactcctgactatgaaccccatgaccatgatatcttggcagcatttcgagtaactcctcaacctggagttccaccagaagaagcaggggctgcggtagctgccgaatcttctactggtacatggacaactgtgtggaccgatggacttaccagccttgatcgttacaaaggacgatgctaccacatcgagcctgttcctggcgaagaa";
    cl.backgroundColor = c2;	cl.color = c1;
    rb.backgroundColor = c1;	rb.color = c2;
    ma.backgroundColor = c2;	ma.color = c1;
    };
    }
  </script>
@endsection
