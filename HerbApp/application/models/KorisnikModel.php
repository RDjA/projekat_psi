<?php

//Sva komunikacija sa bazom podataka se nalazi u Modelima
//Kada god se napravi nov model dodati ga u application/confin/autoload.php u autoload model array(poslednja linija autoload.php)
//Svaki model treba minimalno  da ima CRUD metode(create, update, use/find, delete)
class KorisnikModel extends CI_Model{
    
    //Funkcija za kreiranje korisnika
    public function create($korisnickoIme, $ime, $prezime, $lozinka, $email, $kategorija, $zvanje, $brTel, $status){
        
        $korisnik = array(
            'korisnickoIme' => $korisnickoIme,
            'ime' => $ime,
            'prezime' => $prezime,
            'lozinka' => $lozinka,
            'email' => $email,
            'kategorija' => $kategorija,
            'zvanje' => $zvanje,
            'brTel' => $brTel,
            'status' => $status,
            );
        
        $this->db->insert('korisnik',$korisnik);
    }
    
    //Ukoliko odredjeno polje ne treba da se update-uje proslediti vrednost starog podatka, nikako null!
    //Id odredjuje koji korisnik se update-uje.
    public function update($id,$korisnickoIme, $ime, $prezime, $lozinka, $email, $kategorija, $zvanje, $brTel, $status){
        
        $korisnik = array(
            'korisnickoIme' => $korisnickoIme,
            'ime' => $ime,
            'prezime' => $prezime,
            'lozinka' => $lozinka,
            'email' => $email,
            'kategorija' => $kategorija,
            'zvanje' => $zvanje,
            'brTel' => $brTel,
            'status' => $status,
            );
        
        $this->db->where('idKor', $id);
        $this->db->update('korisnik', $korisnik);
    }
    
    public function delete($id){
        $this->db->where('idKor', $id);
        $this->db->delete('korisnik');
    }
    
    //Proverava da li je korisnik sa zadatim korisnickim imenom i lozinkom u bazi i vraca kategoriju korisnika 
    public function getLoginKategorija($korIme, $lozinka){
        
        $this->db->select();
        $this->db->from('korisnik');
        $this->db->where('korisnickoIme', $korIme);
        $this->db->where('lozinka', $lozinka);
        $upit = $this->db->get();
        
        //Legitimne kategorije korisnika su : admin, zapProizvodnja, zapNabavka i zapMagacin
        //Ukoliko korisnik ne pripada nekoj od ovih kategorija, znaci da ga admin jos uvek nije odobrio
        //Prilikom registracije kategorija se pamti bez zap prefiksa, koji se dodaje kada admin odobri korisnika
        if($upit->num_rows() > 0){
            $result = $upit->result();
            $korisnik = $result[0];
            if((strcmp($korisnik->kategorija, 'zapProizvodnja') == 0)
                    || (strcmp($korisnik->kategorija, 'zapNabavka') == 0)
                            || (strcmp($korisnik->kategorija, 'zapMagacin') == 0)
                    || (strcmp($korisnik->kategorija, 'admin') == 0))
                    
                return $korisnik;
        }
        return null;
    }

    public function getAll(){
        $svi = $this->db->get('korisnik');
        return $svi->result();
    }


    public function getById($id){
        $this->db->select();
        $this->db->from('korisnik');
        $this->db->where('idKor', $id);
        $upit = $this->db->get();

        $res = $upit->result();
        if($upit->num_rows() > 0)
            return $res[0];
        else
            return null;
    }
    public function getByUsername($username){
        
        $this->db->select();
        $this->db->from('korisnik');
        $this->db->where('korisnickoIme', $username);
        $upit = $this->db->get();

        $res = $upit->result();
        if($upit->num_rows() > 0)
            return $res[0];
        else
            return null;
    }
    
    
    
     public function getByName($str){
        $svi = $this->db->get('korisnik');
        
        $korisnici = $svi->result();
        
        if ($str === "sviKorisniciPrintdfadsuhfiusdhfoais") return $korisnici;
        
        $rez = array();
        
        foreach($korisnici as $korisnik){
            if (strpos(strtolower($korisnik->ime),strtolower($str)) === 0) {
                array_push($rez, $korisnik);
            }
        }
        
        return $rez;
    }
  
    
}
?>
