<?php
defined('BASEPATH') OR exit ('No direct script allowed access');

class M_antecedentes extends CI_model{
    public function inserirAntecedentes($nome){
        $retornoAntecedente = $this->conferirAntecedente($nome);
        if($retornoAntecedente['codigo'] == 30){
            $dados = array('codigo' => ,
                           'msg'    => $retornoAntecedente['msg']);
        }else{
            $sql = "insert into ANTECEDENTES (nome) values ('$nome')";
            $this->db->query($sql);
            if($this->affected_rows() > 0){
                $dados = array('codigo' => ,
                               'msg'    => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => ,
                                'msg'   => $retornoAntecedente['msg']);
            }
        }
        return $dados;
    }

    public function conferirAntecedente($idAntec, $nome){
        $sql = "select * from ANTECEDENTES"
        $retorno = $this->db->query($sql);

        if($retorno-> num_rows() > 0){
            $dados = array('codigo' => ,
                           'msg'    => 'Antecedentes já cadastrada');
        }else{
            $dados = array('codigo' => ,
                           'msg'    => 'Nada encontrado');
        }
        return $dados;
    }

    public function atualizarAntecedentes($idAntec, $nome){
        $retornoAntecedente = $this->conferirAntecedente($idAntec);
        if($retornoAntecedente['codigo'] == 30){
            $sql = "update ANTECEDENTES set nome = '$nome' where id_antec = $idAntec";

            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' =>  ,
                                'msg'   => 'Aspecto atualizado');
            }else{
                $dados = array('codigo' => ,
                               'msg'    => 'Houve algum problema na atualização');
            }
        }else{
            $dados = array('codigo' => 15,
                            'msg'   => $retornoAntecedente['msg']);
        }
        return $dados;
    }

    public function apagarAntecedente($idAntec){
        $retornoAntecedente = $this->conferirAntecedente($idAntec);
        if($retornoAntecedente['codigo'] == 30){
            $sql = "delete from ANTECEDENTES where id_antec = $idAntec";
            
            $retorno = $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 'Aspecto apagado');
            }else{
                $dados = array('codigo' => ,
                               'msg'    => 'Houve algum problema na exclusão');
            }
        }else{
            $dados = array('codigo' => ,
                           'msg'    => $retornoAntecedente['msg']);
        }
        return $dados;
    }
}