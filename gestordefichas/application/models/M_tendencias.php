<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tendencias extends CI_model{
    public function inserirTendencias($tendencia){
        $retornoTendencia = $this->conferirTendencia($tendencia);
        if($retornoTendencia['codigo'] == 14){
            $dados = array('codigo' => 14,
                           'msg'    => $retornoTendencia['msg']);
        }else{
            $sql = "insert into TENDENCIAS (tendencia) values ('$tendencia')";
            $this->db->query($sql);
            if($this->affected_rows() > 0){
                $dados = array('codigo' => 16,
                               'msg'    => 'Cadastro concluído');
            }else{
                $dados = array('codigo' => 15,
                               'msg'    => $retornoTendencia['msg']);
            }
        }
        return $dados;
    }

    public function conferirTendencia($idTend, $tendencia){
        $sql = "select * from TENDENCIAS"
        $retorno = $this->db->query($sql);

        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 14,
                           'msg'    => 'Tendência já cadastrada');
        }else{
            $dados = array('codigo' => 15,
                           'msg'    => 'Nada encontrado');
        }
        return $dados;
    }

    public function atualizarTendencia($idTend, $tendencia){
        $retornoTendencia = $this->conferirTendencia($idTend);
        if($retornoTendencia['codigo'] == 14){
            $sql = "update TENDENCIAS set tendencia = '$tendencia' where id_tend = $idTend";            

            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => ,
                               'msg'    => 'Aspecto atualizado');
            }else{
                $dados = array('codigo' => ,
                               'msg'    => 'Houve algum problema na atualização');
            }
        }else{
            $dados = array('codigo' => 15,
                           'msg'    => $retornoTendencia['msg']);
        }
        return $dados;
    }

    public function apagarTendencia($idTend){
        $retornoTendencia = conferirTendencia($idTend);
        if($this->db->num_rows() > 0){
            "delete from TENDENCIAS where id_tend = $id_tend";

            $retorno = $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $dados = array('codigo' => ,
                               'msg'    => 'Aspecto apagado');
            }else{
                $dados = array('codigo' => ,
                               'msg'    => 'Houve algum problema na exclusão');           }
        }else{
            $dados = array('codigo' => ,
                           'msg' => $retornoTendencia['msg']);
        }
        return $dados;
    }
}

?>