<?php
defined('BASEPATH') OR exit ('No direct script allowed access');

class M_Antecedente extends CI_model{
    public function inserirAntecedente($antecedente){
        $retornoAntecedente = $this->conferirAntecedente($antecedente);
        if($retornoAntecedente['codigo'] == 1){
            $dados = array('codigo' => 22,
                           'msg'    => $retornoAntecedente['msg']);
        }else{
            $sql = "insert into ANTECEDENTES (antecedente) values ('$antecedente')";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 7,
                               'msg'    => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => 6,
                                'msg'   => 'Houve um problema ao efetuar ação');
            }
        }
        return $dados;
    }

    public function alterarAntecedente($idAntec, $antecedente){
        $retornoID = $this->validarAntecedente($idAntec);
        if($retornoID['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoID['msg']);
        }else{
            $retornoAntecedente = $this->conferirAntecedente($antecedente);
            if($retornoAntecedente['codigo'] == 1){
                $dados = array('codigo' => 22,
                                'msg' => $retornoAntecedente['msg']);
            }else{
                $sql = "update ANTECEDENTES set antecedente = '$antecedente'";
                $this->db->query($sql);
                if($this->db->affected_rows() > 0){
                    $dados = array('codigo' => 12,
                                    'msg' => 'Dados alterados');
                }else{
                    $dados = array('codigo' => 11,
                                    'msg' => $retornoAntecedente['msg']);
                }
            }
        }
        return $dados;
    }

    public function apagarAntecedente($idAntec){
        $retornoAntecedente = $this->validarAntecedente($idAntec);
        if($retornoAntecedente['codigo'] == 1){
            $sql = "delete from ANTECEDENTES where id_antec = $idAntec";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 15,
                                'msg' => 'Dado apagado');
            }else{
                $dados = array('codigo' => 6,
                               'msg'    => 'Houve algum problema ao efetuar função');
            }
        }else{
            $dados = array('codigo' => 11,
                           'msg'    => $retornoAntecedente['msg']);
        }
        return $dados;
    }

    #       MÉTODOS DE APOIO
    public function conferirAntecedente($antecedente){
        $sql = "select * from ANTECEDENTES where antecedente = '$antecedente'";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg'    => 'Antecedente já cadastrado');
        }else{
            $dados = array('codigo' => 2,
                           'msg'    => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    public function validarAntecedente($idAntec){
        $sql = "select * from ANTECEDENTES where id_antec = $idAntec";
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg'    => 'Antecedentes válido');
        }else{
            $dados = array('codigo' => 2,
                           'msg'    => 'Nenhum dado encontrado');
        }
        return $dados;
    }
}