<?php

class SirovinaModel extends CI_Model{
    
    //Funkcija za kreiranje sirovine
    public function create($naziv, $serBr, $vremePristiz, $jedinica, $magacinUk, $magacinRez){
        
        $sirovina = array(
            'naziv' => $naziv,
            'serBr' => $serBr,
            'vremePristiz' => $vremePristiz,
            'jedinica' => $jedinica,
            'magacinUk' => $magacinUk,
            'magacinRez' => $magacinRez,
            );
        
        $this->db->insert('sirovina',$sirovina);
    }
    
    //Ukoliko odredjeno polje ne treba da se update-uje proslediti vrednost starog podatka, nikako null!
    //Id odredjuje koja sirovina se update-uje.
    public function update($id, $naziv, $serBr, $vremePristiz, $jedinica, $magacinUk, $magacinRez){
        
        $sirovina = array(
            'naziv' => $naziv,
            'serBr' => $serBr,
            'vremePristiz' => $vremePristiz,
            'jedinica' => $jedinica,
            'magacinUk' => $magacinUk,
            'magacinRez' => $magacinRez,
            );
        
        $this->db->where('idSirovine',$id);
        $this->db->update('sirovina',$sirovina);
    }
    
    //Brisanje sirovine
    public function delete($id){
        $this->db->where('idSirovine', $id);
        $this->db->delete('sirovina');
    }
    
    public function getById($id){
        
        $this->db->select();
        $this->db->from('sirovina');
        $this->db->where('idSirovine', $id);
        $upit = $this->db->get();
        
        $res = $upit->result();
        if($upit->num_rows() > 0)
        return $res[0];
        else
            return null;
    }
    public function getByNaziv($naziv){
        
        $this->db->select();
        $this->db->from('sirovina');
        $this->db->where('naziv', $naziv);
        $upit = $this->db->get();
        
        $res = $upit->result();
        if($upit->num_rows() > 0)
        return $res[0];
        else
            return null;
    }
    
    
    public function addToRezervisano($id, $kol){
        
        $sirovina = $this->getById($id);
        $magacinRez = $sirovina->magacinRez + $kol;
        $new = array('magacinRez' => $magacinRez);
        
        $this->db->where('idSirovine', $id);
        $this->db->update('sirovina', $new);
    }
    
    public function removeFromRezervisano($id, $kol){
        
        $this->addToRezervisano($id, -$kol);
    }
    
    public function addToMagacin($id, $kol){
        
        $sirovina = $this->getById($id);
        $magacinUk = $sirovina->magacinUk + $kol;
        $new = array('magacinUk' => $magacinUk);
        
        $this->db->where('idSirovine', $id);
        $this->db->update('sirovina', $new);
    }
    
    public function removeFromMagacin($id, $kol){
        
        $this->addToMagacin($id, -$kol);
    }
	
	public function getAll(){
	$all = $this->db->get('sirovina');
        return $all->result();
	}
	
	public function getByName($name){
		
		$svi = $this->db->get('sirovina');
        
        $sirovine = $svi->result();
        if ($str === "none") return null;
       
				
        $rez = array();
        
        foreach($sirovine as $sirovina){
            if (strpos(strtolower($sirovina->naziv),strtolower($name)) === 0) {
                array_push($rez, $sirovina);
            }
        }
        
        return $rez;
		
		
		
	}
	public function getByName1($name){
		
		$svi = $this->db->get('sirovina');
        
        $sirovine = $svi->result();
        if ($name === "") return null;

        foreach($sirovine as $sirovina){
            if ($sirovina->naziv===$name) return $sirovina;

        }
		
	}
	
	
}
?>
