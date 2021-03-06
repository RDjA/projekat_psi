<?php

class ZahtevProizvodnjaModel extends CI_Model{
    
    //Funkcija za kreiranje zahteva
    public function create($idProizvod, $datum, $kolicina, $status){
        
        $proizvodnjaZahtev = array(
            'idProizvod' => $idProizvod,
            'datum' => $datum,
            'kolicina' => $kolicina,
            'status' => $status,
            );
        
        $this->db->insert('zahtevproizvodnja',$proizvodnjaZahtev);
        return $this->db->insert_id();
    }
    
    //Ukoliko odredjeno polje ne treba da se update-uje proslediti vrednost starog podatka, nikako null!
    //Id odredjuje koji zahtev se update-uje.
    public function update($id, $idProizvod, $datum, $kolicina, $status){
        
        $proizvodnjaZahtev = array(
            'idProizvod' => $idProizvod,
            'datum' => $datum,
            'kolicina' => $kolicina,
            'status' => $status,
            );
        
        $this->db->where('idZahtev',$id);
        $this->db->update('zahtevproizvodnja',$proizvodnjaZahtev);
    }
    
    //Brisanje zahteva
    public function delete($id){
        $this->db->where('idZahtev', $id);
        $this->db->delete('zahtevproizvodnja');
    }
    
     //Ne pobrkati ovu funkciju sa refreshStatus!
    public function updateStatus($idZahtev, $newStatus){
        
        $zahtev = array('status' => $newStatus);
        
        $this->db->where('idZahtev',$idZahtev);
        $this->db->update('zahtevproizvodnja', $zahtev);
    }
    
    public function getById($id){
                
        $this->db->select();
        $this->db->from('zahtevproizvodnja');
        $this->db->where('idZahtev', $id);
        $upit = $this->db->get();
        
        $res = $upit->result();
        if($upit->num_rows() > 0)
        return $res[0];
        else
            return null;
    
    }
    
    public function getAll(){
        
        $this->db->select();
        $this->db->from('zahtevproizvodnja');
        $this->db->order_by('datum','asc');
        $svi = $this->db->get();
        
        return $svi->result();
    }
    
    public function getAllZahtevSirovineForZahtevProizvod($id){
        
        $this->db->select();
        $this->db->from('zahtevsirovina');
        $this->db->where('idZahtevProiz', $id);
        $upit = $this->db->get();
        
        return $upit->result();
    }
    
    //Updateuje se status proizvoda ukoliko su sve potrebne sirovine rezervisane.
    //Funkcija se poziva kada se promeni status nekog zahteva za sirovinom.
    public function refreshStatus($id){
        
        if($id < 0) return;//za slucaj da je zahtev bez proizvoda(porucila nabavka)
        
        $zahtevi = $this->getAllZahtevSirovineForZahtevProizvod($id);
        
        $isReserved = true;
        foreach($zahtevi as $zahtev){
            if((strcmp($zahtev->status,'reserved')) != 0)
                $isReserved = false;
        }
        
        if($isReserved) 
        {
            $zahtevPr = $this->getById($id);
            $this->update($id, $zahtevPr->idProizvod, $zahtevPr->datum, $zahtevPr->kolicina, 'reserved');
        }
    }
    
    //Oslobadjaju se do sada rezervisane sirovine i dodeljuju drugim proizvodima koji cekaju na te sirovine
    public function releaseReservedSirovine($idZahtev){
        
        $zahteviSirovine = $this->getAllZahtevSirovineForZahtevProizvod($idZahtev);
        
        foreach($zahteviSirovine as $zahtev){
            
            $this->zahtevSirovinaModel->update($idZahtev, $zahtev->idZahtevSirov, $zahtev->datumKreiranja, $zahtev->datumComplete, 0, 0, 'rejected');
            $this->sirovinaModel->removeFromRezervisano($zahtev->idZahtevSirov, $zahtev->rezervisano);
            $this->zahtevSirovinaModel->refreshAllZahtevi($zahtev->idZahtevSirov);
        }
    }
    
    //Prilikom potvrde o pravljenju proizvoda za koji su rezervisane sve sirovine, sirovine se oduzimaju iz magacina
    public function confirmReservedProizvod($idZahtev){
        
        $zahtevSirovine = $this->getAllZahtevSirovineForZahtevProizvod($idZahtev);
        
        foreach($zahtevSirovine as $zahtev){
            
            $sirovina = $this->sirovinaModel->getById($zahtev->idZahtevSirov);
            //Sirovine se oduzimaju i od ukupnog stanja u magacinu i od broja rezervisanih
            $this->sirovinaModel->removeFromMagacin($sirovina->idSirovine, $zahtev->kolicina);
            $this->sirovinaModel->removeFromRezervisano($sirovina->idSirovine, $zahtev->kolicina);
        }
    }
    
        public function getActiveRequests(){
            
        $this->db->select();
        $this->db->from('zahtevproizvodnja');
        $this->db->where('status', 'pending');
        $this->db->or_where('status', 'rejected');
        $this->db->or_where('status', 'reserved');
        $this->db->order_by('datum','desc');
        $upit = $this->db->get();
        
        return $upit->result();
        }
        
        public function getArchivedRequests(){
            
        $this->db->select();
        $this->db->from('zahtevproizvodnja');
        $this->db->where('status', 'complete');
        $this->db->or_where('status', 'incomplete');
        $this->db->order_by('datum','desc');
        $upit = $this->db->get();
        
        return $upit->result();
        }
    
}
?>
