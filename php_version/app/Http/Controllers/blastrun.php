<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class blastrun extends Controller
{
    public function index(){
        /*
        blast���s���̃��\�b�h
        pre�����͒l��validation�Ŏ��{
        post������html�̐��`����
        ���̃R���g���[���[�ł͉������{����H
        ��X��DB����f�[�^�擾��
        ���F
        �P�D�t�@�C�����𐶐�
        �Q�D�t�@�C���������o��
        �R�Dblast���s
        �S�D�t�@�C���T�C�Y�m�F
        �T�Dresult�t�@�C���ǂݏo������DB�o�^�H
        �U�D��ʃt�@�C���ǂݏo��
        �V�D�T�ƂU�̕R�Â�
        �W�D���ʂ̕\������post��middleware�ɂĎ���
        �R���g���[���Ƃ��ă��[�g����Ăяo�������̃V���O�����\�b�h�ɂ��Ă����B
        ����ȊO��private�Ƃ��Ċ֐��𕪊�����B
        */
        return view("index");
    }
    
    static function getfileName(){
        $randomNum = rand(0,10000);
        return $randomNum;
    }

    /*
        Write user input sequence to the local file 
        File name is randomly generated.
    */
    static function outQryToText(int $randomNum){
        $file = $randomNum+'.txt';
        $query = $_POST['query'];//get sequences user inputs
        file_put_contents($file,$query,LOCK_EX);
    }

    /*
        Run the Blast application on the server and return the result.
    */
    static function blastRun(int $randomNum){
        $inFileName=  app_path()."../{$randomNum}.fasta";
        $outResultFile = $randomNum.'_result.txt';
        $db         = $_POST['db'];
        $gene       = $_POST['gene'];
        $blastDb    = app_path().'..'."public/resources/{$gene}/db/{$db}/all" ;
        $outFmtOpt  = '"6 std qlen slen"' ;
        $maxTagSeq  = 100;

        $cmd = "blastn -query {$inFileName}  -db {$blastDb} -out {$outResultFile} -outfmt {$outFmtOpt} -max_target_seqs {$maxTagSeq}";
        exec($cmd, $output);
        return $outResultFile;
    }

    static function readResultFile($outputFile){
        $counter = 0; //�t�@�C���̈�s�ڂ̂ݕʏ���  
        $perIdent = [
            'PRSTRAT' => 0, //�g�b�v�q�b�g�����Q�Ɣz��̃A���C�����g�J�n�ʒu�i�P�ʂ́�)
            'PREND'=>0      //�g�b�v�q�b�g�����Q�Ɣz��̃A���C�����g�I���ʒu�i�P�ʂ́��j
        ];
        $objArrayIn_=[];//2 dimentions array. Each item equals to the 1 blast result row.
        $resultFile = fopen($outputFile,"r"); // The file Blast application output.
        if(!$resultFile){
                echo("The file doesn't exist.");
                return false;
        }else{
            while($line = fgets($resultFile)){
                echo $line;
                $counter++;

                $_ = explode($line,'\t');
                $ref        =$_[1];// �Q��(reference)��ID        
                $identity   =$_[2];// �A���C�����g�����z�񒷂ɂ������v��
                $alignLen   =$_[3];// �A���C�����g��
                $missMatch  =$_[4];// �~�X�}�b�`�̃J�E���g
                $gapOpen    =$_[5];// �M���b�v���������ӏ��̃J�E���g
                $qstart     =$_[6];// �N�G���̃A���C�����g�J�n�ʒu
                $qend       =$_[7];// �N�G���̃A���C�����g�I���ʒu
                $rstart     =$_[8];// �Q�Ƃ̃A���C�����g�J�n�ʒu
                $rend       =$_[9];// �Q�Ƃ̃A���C�����g�I���ʒu
                $eval       =$_[10];// E-value
                $bitScore   =$_[11];// �X�R�A�i�傫������2�̔z��͗ގ����Ă���ƌ�����j

                if(counter==1){
                    
                    $maxSeqs = 1035;//The max length of the gene seq is 1035
                    $displayStart= (rstart/$maxSeqs)*100 + '%';//the start positon of refseq to display in SVG file

                    $displayEnd = '';//the End positon of refseq to display in SVG file
                    $_ = (rend/$maxSeqs)+100;
                    if($_ >100){
                        $displayEnd='100%';
                    }{
                        $displayEnd= "{$_}%";
                    }
                    $perIdent['PRSTRAT']= $displayStart;
                    $perIdent['PREND']=$displayEnd;
                }else{
                    array_push($objArrayIn_,[
                            URL=>"https://www.ncbi.nlm.nih.gov/protein/{$ref}", // �������ʂɕ\������URL
                            REF=>$ref       ,     // �Q�Ɣz��(reference)��ID
                            SPE=>'' ,     // �햼
                            IDEN=>$identity ,     // �A���C�����g�����z�񒷂ɂ������v��
                            ALEN=>$alignLen ,     // �A���C�����g��
                            MM=>$missMatch  ,     // �~�X�}�b�`�̑���
                            GA=>$gapOpen    ,     // �M���b�v���������ӏ��̑���
                            QS=>$qstart     ,     // �N�G���̃A���C�����g�J�n�ʒu
                            QE=>$qend       ,     // �N�G���̃A���C�����g�I���ʒu
                            RS=>$rstart     ,     // �Q�Ƃ̃A���C�����g�J�n�ʒu
                            RE=>$rend       ,     // �Q�Ƃ̃A���C�����g�I���ʒu
                            EV=>$eval       ,     // E-value�l
                            BS=>$bitScore   ,     // �r�b�g�X�R�A�i�傫������2�̔z��͗ގ����Ă���ƌ�����j
                        ]
                    );
                }

            }
        }

        //after reading file
        return [
            perIdent=>perIdent_,
            objArrayIn=>objArrayIn_
        ];
    }
}
