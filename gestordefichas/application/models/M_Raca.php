<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Raca extends CI_Model{
    public function inserirRaca($raca, $deslocamento){
        $retornoRaca = $this->conferirRaca($raca);
        if($retornoRaca['codigo'] == 5){
            $dados = array('codigo' => 5,
                            'msg' => $retornoRaca['msg']);
        }else{
            $sql = "insert into RACAS (raca, deslocamento) values ('$raca', $deslocamento)";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 7,
                                'msg' => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => 6,
                                'msg' => 'Houve um problema ao cadastrar');
            }
        }
        return $dados;
    }


    #MÉTODOS DE APOIO
    public function conferirRaca($raca){
        $sql = "select * from RACAS where raca = '$raca'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 5,
                            'msg' => 'Raça já cadastrada');
        }else{
            $dados = array('codigo' => 6,
                            'msg' => 'Houve um problema ao cadastrar');
        }
        return $dados;
    }
}
?>