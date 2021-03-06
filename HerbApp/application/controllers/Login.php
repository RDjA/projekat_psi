<?php

//Ovo je Default Controller koji aplikacija poziva
//Konfigurisan u application/config/routes.php
class Login extends CI_Controller {

    function index() {
        /*
         * Template je Helper koji je definisan u application/libraries        
         * Sluzi za generisanje template-a u View-ima
         * Prvi argument je template koji se poziva
         * Drugi argument je stranica koja se uklapa u template
         * Treci argument su podaci koji se prosledjuju
         * Templati se definisu u application/views/tempaltes
         * Stranica predstavlja template, sadrzaj se umece na mesto $body markera
         * 
         * HerbApp ce najverovatnije imati po jedan template za svaku vrstu korisnika.
         * U svakom template-u ce biti definisan pocetni meni, dok ce telo da budu sadrzaji stranica
         */
        //$this->zahtevSirovinaModel->create(1,3, date('Y/m/d'), date('Y/m/d'), 200, 'complete');
        //$this->zahtevSirovinaModel->delete(1,2);
        $this->template->load('myTemplate', 'login', null);
    }

    function isLoginOk() {
        $korIme = $this->input->post('username');
        $lozinka = $this->input->post('password');

        $korisnik = $this->korisnikModel->getLoginKategorija($korIme, $lozinka);
        if ($korisnik == null) {
            $this->template->load('myTemplate', 'login', null);
        } else {
            $this->load->library('session');
            $newdata = array(
                'id' => $korisnik->idKor,
                'kategorija' => $korisnik->kategorija,
                'ime' => $korisnik->ime,
                'prezime' => $korisnik->prezime,
                'username' => $korisnik->korisnickoIme,
            );

            $this->session->set_userdata($newdata);

            if (strcmp($korisnik->kategorija, 'zapProizvodnja') == 0) {
                redirect('proizvodnja/listaProizvoda');
            } else if (strcmp($korisnik->kategorija, 'zapNabavka') == 0) {
                redirect('nabavka/listaZahtevi');
            } else if (strcmp($korisnik->kategorija, 'zapMagacin') == 0) {
                redirect('magacin/listaMagacin');
            } else if (strcmp($korisnik->kategorija, 'admin') == 0) {
                redirect('admin/korisnici');
            }
        }
    }

    function registracija() {

        $data['registracija'] = 1;
        $this->template->load('myTemplate', 'admin/kreirajKorisnikaPrikaz', $data);
    }

    function logout() {
        $this->load->library('session');
        $this->session->sess_destroy();
        $this->template->load('myTemplate', 'login', null);
    }

}

?>
