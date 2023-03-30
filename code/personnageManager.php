<?php

class personnageManager{
    private $db;

    public function __construct($db){
        $this->setDb($db);
    }

    public function setDb (PDO $db){
        $this->db=$db;
    }

    public function getList(){
        $query=$this->db->query('SELECT id, name, atk, pv FROM personnage ORDER BY name');
        while ($donnees = $query->fetch(PDO::FETCH_ASSOC)){
            $personnage[] = new Personnage($donnees);
        }
        return $personnage;
    }

    


    public function ajoutPerso($perso_creer, $img_perso){
        $name = $perso_creer->getName();
        $atk = $perso_creer->getAtk();
        $pv = $perso_creer->getPv();

        $query = "SELECT COUNT(`name`) FROM `personnage` WHERE `name`='$name'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $nbOcc = $stmt->fetch();
    
        if($nbOcc[0] != 0) {
            echo "Le nom est utilisé\n";
        } else {
            if($atk > 30) { $atk = 30; } if ($pv>100) { $pv = 100; }
            $query=$this->db->query("INSERT INTO personnage VALUES ('NULL','$name','$atk','$pv')");
        }
    }

 
    //public function deletePerso($perso_supprimer){
        //$query=$this->db->query("DELETE FROM personnage WHERE personnage.id = ");
        //$query -> execute();
        //$result = $query->fetch(PDO::FETCH_ASSOC);
        //return new Personnage ($result);
    //}


    public function suppPerso($nom_perso){
        $query=$this->db->query("DELETE FROM personnage WHERE personnage.name='$nom_perso'");
        $query -> execute();
    }

    public function modifPerso($id_perso, $pv, $atk){
        if($atk > 30) { $atk = 30; } if ($pv>100) { $pv = 100; }
        $query=$this->db->query("UPDATE personnage SET atk = $atk, pv = $pv WHERE personnage.name='$id_perso'");
        $query -> execute();
    }

    public function choisirPerso($choisir_perso){
        $query=$this->db->query("SELECT pv, atk FROM personnage WHERE personnage.name='$choisir_perso'");
        $query -> execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        echo $result['pv'];
        echo $result['atk'];
    }
    public function regenerer($perso) {

        $query=$this->db->query("SELECT pv FROM personnage WHERE personnage.name='$perso'");
        $query -> execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $pv = $result['pv'];
        if ($pv >= 100) {
            echo "<p>Votre vie est déjà au max : ".$pv."❤</p>";
            $query=$this->db->query("UPDATE personnage SET pv = 100 WHERE personnage.name='$perso'");
        } else {
            $query=$this->db->query("UPDATE personnage SET pv = $pv+10 WHERE personnage.name='$perso'");
        }
    }
    public function atkPerso($attaquant_perso, $attaque_perso){
        $query=$this->db->query("SELECT atk FROM personnage WHERE personnage.name='$attaquant_perso'");
        $query -> execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $atk = $result['atk'];

        $query=$this->db->query("SELECT pv, name FROM personnage WHERE personnage.name='$attaque_perso'");
        $query -> execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $pv = $result['pv'];
        $name = $result['name'];

        if ($pv > 0) {
            $query=$this->db->query("UPDATE personnage SET pv=$pv-$atk WHERE personnage.name='$attaque_perso'");
            $query -> execute();

            echo ''.$name.' '.$pv.' ❤ '.$atk.' ⚔ <br>';
        }
        else {
            echo ''.$attaque_perso.' a perdu !<br>
            <form action="" name="relancerPartie" method="post">
                <button type="text" class="submit" id="relancer" name="relancer">Relancer</button>
            </form>';
        }
    }


    public function getPerso($name_perso){
        $query=$this->db->query("SELECT name, atk, pv FROM personnage WHERE personnage.name='$name_perso'");
        $query -> execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        echo ''.$result['name'].' '.$result['pv'].' ❤ '.$result['atk'].' ⚔ <br>';
    }

    //$query =$this->db->query("UPDATE personnage SET name=$name, atk=$atk, pv=$pv");

}





?>
