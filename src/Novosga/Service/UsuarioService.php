<?php
namespace Novosga\Service;

use Novosga\Model\Unidade;
use Novosga\Model\Usuario;
use Novosga\Model\Util\UsuarioSessao;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * UsuarioService
 *
 * @author Rogério Lino <rogeriolino@gmail.com>
 */
class UsuarioService extends ModelService {
    
    /**
     * 
     * @param Usuario|integer $usuario
     * @param Unidade|integer $unidade
     * @return ArrayCollection
     */
    public function lotacoes($usuario, $unidade) {
        return $this->em
                ->createQuery("
                    SELECT
                        l
                    FROM
                        Novosga\Model\Lotacao l
                        LEFT JOIN l.usuario u
                        LEFT JOIN l.grupo g
                        LEFT JOIN l.cargo c
                    WHERE
                        g.left <= (
                            SELECT g2.left FROM Novosga\Model\Grupo g2 WHERE g2.id = (SELECT u2g.id FROM Novosga\Model\Unidade u2 INNER JOIN u2.grupo u2g WHERE u2.id = :unidade)
                        ) AND
                        g.right >= (
                            SELECT g3.right FROM Novosga\Model\Grupo g3 WHERE g3.id = (SELECT u3g.id FROM Novosga\Model\Unidade u3 INNER JOIN u3.grupo u3g WHERE u3.id = :unidade)
                        )
                ")
                ->setParameter('usuario', $usuario)
                ->setParameter('unidade', $unidade)
        ;
    }
    
    /**
     * Retorna a lista de serviços que o usuário atende na determinada unidade
     * @param Usuario|UsuarioSessao|integer $usuario
     * @param Unidade|integer $unidade
     * @return ArrayCollection
     */
    public function servicos($usuario, $unidade) {
        return $this->em
                ->createQuery("
                    SELECT 
                        e 
                    FROM 
                        Novosga\Model\ServicoUsuario e 
                        JOIN 
                            e.servico s
                    WHERE 
                        e.usuario = :usuario AND 
                        e.unidade = :unidade AND 
                        s.status = 1
                    ORDER BY
                        s.nome
                ")
                ->setParameter('usuario', $usuario)
                ->setParameter('unidade', $unidade)
                ->getResult();
    }
    
}