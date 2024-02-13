<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Tendencia extends CI_model{
    public function inserirTendencia($tendencia){
        $retornoTendencia = $this->conferirTendencia($tendencia);
        if($retornoTendencia['codigo'] == 1){
            $dados = array('codigo' => 18,
                           'msg'    => $retornoTendencia['msg']);
        }else{
            $sql = "insert into TENDENCIAS (tendencia) values ('$tendencia')";
            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 7,
                               'msg'    => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => 6,
                               'msg'    => 'Houve um problema ao efetuar função');
            }
        }
        return $dados;
    }

    public function consultarTendencia($idTend, $tendencia){
        if($idTend == "" and $tendencia == ""){
            $sql = "select * from TENDENCIAS";
        }elseif($idTend != "" and $tendencia == ""){
            $sql = "select * from TENDENCIAS where id_tend = $idTend";
        }elseif($idTend == "" and $tendencia != ""){
            $sql = "select * from TENDENCIAS where tendencia like '%$tendencia%'";
        }else{
            $sql = "select * from TENDENCIAS where tendencia like '%$tendencia%' and id_tend = $idTend";
        }
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 88,
                            'dados' => $retorno->result());
        }else{
            $dados = array('codigo' => 11,
                            'msg' => 'Nenhum dado encontrado');
        }

        return $dados;
    }

    public function alterarTendencia($idTend, $tendencia){
        $retornoID = $this->validarTendencia($idTend);
        if($retornoID['codigo'] == 1){
            $retornoTendencia = $this->conferirTendencia($tendencia);
            if($retornoTendencia['codigo'] == 1){
                $dados = array('codigo' => 18,
                                'msg' => $retornoTendencia['msg']);
            }else{
                $sql = "update TENDENCIAS set tendencia = '$tendencia' where id_tend = $idTend";            

                $this->db->query($sql);
                if($this->db->affected_rows() > 0){
                    $dados = array('codigo' => 19,
                                   'msg'    => 'Tendência alterada');
                }else{
                    $dados = array('codigo' => 6,
                                   'msg'    => 'Houve algum problema ao efetuar função');
                }
            }
        }else{
            $dados = array('codigo' => 11,
                           'msg'    => $retornoID['msg']);
        }
        return $dados;
    }

    public function apagarTendencia($idTend){
        $retornoTendencia = $this->validarTendencia($idTend);
        if($retornoTendencia['codigo'] == 2){
            $dados = array('codigo' => 11,
                            'msg' => $retornoTendencia['msg']);
        }else{
            $sql = "delete from TENDENCIAS where id_tend = $idTend";

            $this->db->query($sql);
            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => 15,
                                'msg'    => 'Dado apagado');
            }else{
                $dados = array('codigo' => 6,
                                'msg'    => 'Houve um problema ao efetuar função');
            }
        }
        return $dados;
    }

    #   MÉTODOS DE APOIO
    public function conferirTendencia($tendencia){
        $sql = "select * from TENDENCIAS where tendencia = '$tendencia'";
        $retorno = $this->db->query($sql);

        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg'    => 'Tendência já cadastrada');
        }else{
            $dados = array('codigo' => 2,
                           'msg'    => 'Nenhum dado encontrado');
        }
        return $dados;
    }

    public function validarTendencia($idTend){
        $sql = "select * from TENDENCIAS where id_tend = $idTend";
        
        $retorno = $this->db->query($sql);
        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                           'msg'    => 'Tendência já cadastrada');
        }else{
            $dados = array('codigo' => 2,
                           'msg'    => 'Nenhum dado encontrado');
        }
        return $dados;
    }
}

?>