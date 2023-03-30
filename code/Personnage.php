<?php

$db = new PDO('mysql:host=localhost;dbname=poo_sgbd;port=3306;charset=utf8', 'root', '');

class Personnage{

    private static $compteur = 0;
    const MAXLIFE = 100;
    protected $pv;
    protected $atk;
    protected $name;

    public function setPv (int $pv){
        if ($pv>300) {
            $pv=100;
        }
        $this->pv=$pv;
    }

    public function getPv (){
        return $this->pv;
    }

    public function setAtk (int $atk){
        if ($atk>100) {
            $atk=40;
        }
        $this->atk=$atk;
    }

    public function getAtk (){
        return $this->atk;
    }

    public function setName (string $name){
        $this->name=$name;
    }

    public function getName (){
        return $this->name;
    }

    public function getId (){
        return $this->id;
    }

    public static function getCompteur(){
        return self::$compteur;
    }

    public function __construct(array $donnees){
        $this->hydrate($donnees);
        self::$compteur++;
    }

    public function hydrate(array $donnees){
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
            $this->$method($value);
            }
        }
    }

    public function crier(){
        return('Vous ne passerez pas !!!');
    }

    public function regenerer($x=NULL){
        if (is_null($x)) {
            $this->pv=100;
        }
        else {
            $this->pv+=$x;
        }
    }

    public function is_alive(){
        return $this->pv >0;
}

    public function attaque(Personnage $perso){
        $perso->setPv($perso->pv -= $this->atk);
    }

    function reinitPv(){
        $this->setPv(self::MAXLIFE);
    }

}
?>