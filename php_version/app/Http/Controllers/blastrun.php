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
}
