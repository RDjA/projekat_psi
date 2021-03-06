<?php

class Admin extends CI_Controller {

    //pocenti prozor nakon logovanja
    //prikazuje sve delove sistema (korisnici, nabavke, prozivdnja, narudzbine)
    public function home() {
        $this->load->library('session');
        echo $this->session->userdata('id');
        echo $this->session->userdata('ime');
        echo $this->session->userdata('prezime');
        echo $this->session->userdata('kategorija');

        //$this->template->load('adminTemplate', 'admin/pocetna');
    }

    public function neodobreniKorisnici() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $korisnici = $this->korisnikModel->getAll();
        $data['korisnici'] = $korisnici;
        $this->load->view('admin/neodobreniKorisniciPregled', $data);
    }

    //dodavanje, azuriranje korisnicka
    public function korisnici() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $this->korisniciPregled();
        $this->neodobreniKorisnici();
    }

    //prikaz svih korisnika
    public function korisniciPregled() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $korisnici = $this->korisnikModel->getAll();
        $data['korisnici'] = $korisnici;
        $this->template->load('adminTemplate', 'admin/korisniciPregled', $data);
    }

    public function kreirajKorisnika() {
        if (!isset($_POST['korisnickoIme']))
            return;

        $korisnickoIme = $_POST['korisnickoIme'];
        $lozinka = $_POST['lozinka'];
        $kategorija = $_POST['kategorija'];
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email = $_POST['email'];
        $zvanje = $_POST['zvanje'];
        $brTel = $_POST['brTel'];
        $status = $_POST['status'];

        $this->korisnikModel->create($korisnickoIme, $ime, $prezime, $lozinka, $email, $kategorija, $zvanje, $brTel, $status);

        if ($status == 1) {
            $data['content'] = 'Korisnik je uspesno kreiran';
            $this->template->load('adminTemplate', 'admin/message', $data);
        } else {
            $data['content'] = 'Registracija je uspesna. Administrator mora da odobri vasu registraciju';
            $this->template->load('myTemplate', 'admin/message', $data);
        }
    }

    public function obrisiKorisnika($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        if (!isset($id))
            return;
        $this->korisnikModel->delete($id);

        $data['content'] = 'Korisnik id ' . $id . ' je uspesno obrisan';
        $this->template->load('adminTemplate', 'admin/message', $data);
    }

    public function azurirajKorisnika() {
        if (!isset($_POST['korisnickoIme']))
            return;

        $id = $_POST['idKor'];
        $korisnickoIme = $_POST['korisnickoIme'];
        $lozinka = $_POST['lozinka'];
        $kategorija = $_POST['kategorija'];
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email = $_POST['email'];
        $zvanje = $_POST['zvanje'];
        $brTel = $_POST['brTel'];
        $status = $_POST['status'];

        $this->korisnikModel->update($id, $korisnickoIme, $ime, $prezime, $lozinka, $email, $kategorija, $zvanje, $brTel, $status);


        $data['content'] = 'Korisnik ' . $korisnickoIme . ' je uspesno azuriran';
        $this->template->load('adminTemplate', 'admin/message', $data);
    }

    public function azurirajKorisnikaPrikaz($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }
        if (!isset($id))
            return;
        $korisnik = $this->korisnikModel->getById($id);
        $data['korisnik'] = $korisnik;
        $this->template->load('adminTemplate', 'admin/azurirajKorisnikaPrikaz', $data);
    }

    public function kreirajKorisnikaPrikaz() {
        $this->load->library('session');


        $data['registracija'] = 0;
        $this->template->load('adminTemplate', 'admin/kreirajKorisnikaPrikaz', $data);
    }

    public function prihvatiKorisnika($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }
        if (!isset($id))
            return;
        $korisnik = $this->korisnikModel->getById($id);
        $this->korisnikModel->update($korisnik->idKor, $korisnik->korisnickoIme, $korisnik->ime, $korisnik->prezime, $korisnik->lozinka, $korisnik->email, $korisnik->kategorija, $korisnik->zvanje, $korisnik->brTel, 1);

        $data['content'] = 'Korisnik je dodat u bazu';
        $this->template->load('adminTemplate', 'admin/message', $data);
    }

    public function search($str) {

        $korisnici = $this->korisnikModel->getByName($str);

        echo json_encode($korisnici);

        //$data['korisnici'] = $korisnici;
        //$this->template->load('adminTemplate', 'admin/korisniciPregled', $data);
    }

    public function sirovinePregled() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $sirovine = $this->sirovinaModel->getAll();
        $data['sirovine'] = $sirovine;

        $this->template->load('adminTemplate', 'admin/sirovinePregled', $data);
    }

    public function showSirovina($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $sirovina = $this->sirovinaModel->getById($id);
        $data['sirovina'] = $sirovina;

        $this->template->load('adminTemplate', 'admin/sirovinaIzmena', $data);
    }

    public function updateSirovina($id, $magacinRez) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $naziv = $this->input->post('naziv');
        $serBr = $this->input->post('serBr');
        $vremePristiz = $this->input->post('vremePristiz');
        $magacinUk = $this->input->post('magacinUk');
        $jedinica = $this->input->post('jedinica');

        $this->sirovinaModel->update($id, $naziv, $serBr, $vremePristiz, $jedinica, $magacinUk, $magacinRez);

        $this->sirovinePregled();
    }

    public function deleteSirovina($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $this->sirovinaModel->delete($id);

        $this->sirovinePregled();
    }

    public function newSirovina() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $this->template->load('adminTemplate', 'admin/novaSirovina');
    }

    public function createSirovina() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $naziv = $this->input->post('naziv');
        $serBr = $this->input->post('serBr');
        $vremePristiz = $this->input->post('vremePristiz');
        $magacinUk = $this->input->post('magacinUk');
        $jedinica = $this->input->post('jedinica');

        $this->sirovinaModel->create($naziv, $serBr, $vremePristiz, $jedinica, $magacinUk, 0);

        $this->sirovinePregled();
    }

    public function prozivodiPregled() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $proizvodi = $this->proizvodModel->getAll();
        $data['proizvodi'] = $proizvodi;

        $this->template->load('adminTemplate', 'admin/prozivodiPregled', $data);
    }

    public function newProizvod() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $sirovine = $this->sirovinaModel->getAll();
        $data['sirovine'] = $sirovine;
        $this->template->load('adminTemplate', 'admin/noviProizvod', $data);
    }

    public function createProizvod() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $naziv = $this->input->post('naziv');
        $serBr = $this->input->post('serbr');
        $sirovine = $this->input->post('sirovine');
        $kolicina = $this->input->post('kolicine');
        $this->proizvodModel->create($naziv, 0, $serBr, 0);
        $pr = $this->proizvodModel->getByName($naziv);
        for ($i = 0; $i < count($sirovine); ++$i) {
            $name = $sirovine[$i];
            $s = $this->sirovinaModel->getByName1($name);
            $idsir = $s->idSirovine;
            $kol = $kolicina[$i];
            $this->proizvodModel->newProizvodSadrzi($pr->idProizvoda, $idsir, $kol);
        }
    }

    public function showProizvod($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $data = array();
        $proizvod = $this->proizvodModel->getById($id);
        $data['proizvod'] = $proizvod;
        $sirovine = $this->sirovinaModel->getAll();
        $data['sirovine'] = $sirovine;
        $prSadr = $this->proizvodModel->getProizvodSadrzi($id);
        $sirovineSadr = array();
        $kolicinaSadr = array();

        foreach ($prSadr as $row) {
            $sirovina = $this->sirovinaModel->getById($row->idSirovina);
            $sirovineSadr[$row->idSirovina] = $sirovina->naziv;
            $kolicinaSadr[$row->idSirovina] = $row->kolicina;
        }


        $data['nazivi'] = $sirovineSadr;
        $data['kolicine'] = $kolicinaSadr;


        $this->template->load('adminTemplate', 'admin/proizvodIzmena', $data);
    }

    public function updateProizvod() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $id = $this->input->post("idPr");
        $naziv = $this->input->post('naziv');
        $serBr = $this->input->post('serbr');
        $sirovine = $this->input->post('sirovine');
        $kolicina = $this->input->post('kolicine');
        $this->proizvodModel->update($id, $naziv, 0, $serBr, 0);

        $this->proizvodModel->updateproizvodsadrzi($id);


        for ($i = 0; $i < count($sirovine); ++$i) {
            $name = $sirovine[$i];
            $s = $this->sirovinaModel->getByName1($name);
            $idsir = $s->idSirovine;
            $kol = $kolicina[$i];
            $this->proizvodModel->newProizvodSadrzi($id, $idsir, $kol);
            // $this->proizvodModel->newProizvodSadrzi(9,9,9);
        }
        $this->prozivodiPregled();
    }

    public function deleteProizvod($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $this->proizvodModel->delete($id);

        $this->prozivodiPregled();
    }

    //pretraga za novi pr.

    public function searchPr($str) {

        $sirovine = $this->sirovinaModel->getByName($str);

        echo json_encode($sirovine);
    }

    public function showProizvodnjaPregled() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $zahtevi = $this->zahtevProizvodnjaModel->getArchivedRequests();
        $data = array();
        $data['zahtevi'] = $zahtevi;

        $proizvodi = array();
        foreach ($zahtevi as $zahtev) {
            $proizvod = $this->proizvodModel->getById($zahtev->idProizvod);
            $proizvodi[$zahtev->idProizvod] = $proizvod;
        }
        $data['proizvodi'] = $proizvodi;

        $this->template->load('adminTemplate', 'admin/proizvodnjaPregled', $data);
    }

    public function showZahtevProizvodnja($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $zahtev = $this->zahtevProizvodnjaModel->getById($id);
        $data['zahtev'] = $zahtev;

        $proizvod = $this->proizvodModel->getById($zahtev->idProizvod);
        $data['proizvod'] = $proizvod;

        $sviProizvodi = $this->proizvodModel->getAll();
        $options = array();
        foreach ($sviProizvodi as $row) {
            $options[$row->idProizvoda] = $row->naziv;
        }
        $data['options'] = $options;
        //$nazivi = array('nazivProizvoda', $options, $zahtev->idProizvod);
        //$data['nazivi'] = $nazivi;

        $this->template->load('adminTemplate', 'admin/editZahtevProizvodnja', $data);
    }

    public function updateZahtevProizvodnja($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $idProizvod = $this->input->post('nazivProizvoda');
        $datum = $this->input->post('datum');
        $kolicina = $this->input->post('kolicina');
        $status = $this->input->post('status');

        $this->zahtevProizvodnjaModel->update($id, $idProizvod, $datum, $kolicina, $status);
        $this->showProizvodnjaPregled();
    }

    public function deleteZahtevProizvodnja($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $this->zahtevProizvodnjaModel->delete($id);
        $this->showProizvodnjaPregled();
    }

    public function newZahtevProizvodnja() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $sviProizvodi = $this->proizvodModel->getAll();
        $options = array();
        foreach ($sviProizvodi as $row) {
            $options[$row->idProizvoda] = $row->naziv;
        }
        $data['options'] = $options;

        $this->template->load('adminTemplate', 'admin/newZahtevProizvodnja', $data);
    }

    public function createZahtevProizvodnja() {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $idProizvod = $this->input->post('nazivProizvoda');

        $time = strtotime($this->input->post('datum'));
        $datum = date('Y/m/d', $time);

        if (strtotime($datum) < strtotime(date('Y/m/d'))) {
            $error = 'Ne moze se uneti datum iz proslosti';
            $data['error'] = $error;
            $sviProizvodi = $this->proizvodModel->getAll();
            $options = array();
            foreach ($sviProizvodi as $row) {
                $options[$row->idProizvoda] = $row->naziv;
            }
            $data['options'] = $options;
            $this->template->load('adminTemplate', 'admin/newZahtevProizvodnja', $data);
            return;
        }

        $kolicina = $this->input->post('kolicina');
        $status = $this->input->post('status');

        $this->zahtevProizvodnjaModel->create($idProizvod, $datum, $kolicina, $status);
        $this->showProizvodnjaPregled();
    }

    /* public function showNabavkaPregled(){

      $zahtevi = $this->zahtevSirovinaModel->getAllArchived();

      $sirovine = array();
      foreach($zahtevi as $zahtev){
      $sirovina = $this->sirovinaModel->getById($zahtev->idZahtevSirov);
      $sirovine[$zahtev->idZahtevSirov] = $sirovina;
      }

      $data['zahtevi'] = $zahtevi;
      $data['sirovine'] = $sirovine;
      $this->template->load('nabavkaTemplate', 'admin/nabavkaPregled', $data);
      } */

    public function showZahteviSirovine($id) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $zahtevi = $this->zahtevProizvodnjaModel->getAllZahtevSirovineForZahtevProizvod($id);

        $sirovine = array();
        foreach ($zahtevi as $zahtev) {
            $sirovina = $this->sirovinaModel->getById($zahtev->idZahtevSirov);
            $sirovine[$zahtev->idZahtevSirov] = $sirovina;
        }

        $data['zahtevi'] = $zahtevi;
        $data['sirovine'] = $sirovine;

        $this->template->load('adminTemplate', 'admin/zahteviSirovine', $data);
    }

    public function showZahtevNabavka($idZahtevProiz, $idZahtevSirov) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $zahtev = $this->zahtevSirovinaModel->getById($idZahtevProiz, $idZahtevSirov);
        $sirovina = $this->sirovinaModel->getById($idZahtevSirov);

        $data['zahtev'] = $zahtev;
        $data['sirovina'] = $sirovina;

        $this->template->load('adminTemplate', 'admin/editZahtevSirovina', $data);
    }

    public function deleteZahtevNabavka($idZahtevProiz, $idZahtevSirov) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $this->zahtevSirovinaModel->delete($idZahtevProiz, $idZahtevSirov);
        $this->showZahteviSirovine($idZahtevProiz);
    }

    public function updateZahtevNabavka($idZahtevProiz, $idZahtevSirov) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $datum = $this->input->post('datum');
        $kolicina = $this->input->post('kolicina');
        $rezervisano = $this->input->post('rezervisano');
        $status = $this->input->post('status');

        $this->zahtevSirovinaModel->update($idZahtevProiz, $idZahtevSirov, $datum, $datum, $kolicina, $rezervisano, $status);

        $this->showZahteviSirovine($idZahtevProiz);
    }

    public function newZahtevNabavka($idProizv) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $sveSirovine = $this->sirovinaModel->getAll();
        $options = array();
        foreach ($sveSirovine as $row) {
            $options[$row->idSirovine] = $row->naziv;
        }
        $data['options'] = $options;
        $data['idProizv'] = $idProizv;

        $this->template->load('adminTemplate', 'admin/newZahtevNabavka', $data);
    }

    public function createZahtevNabavka($idProizv) {
        $this->load->library('session');
        if (!($this->session->userdata('kategorija') === 'admin')) {
            echo "Nemate pravo pristupa";
            return;
        }

        $idSirovine = $this->input->post('nazivSirovine');
        $kolicina = $this->input->post('kolicina');
        $rezervisano = $this->input->post('rezervisano');
        $status = $this->input->post('status');
        $time = strtotime($this->input->post('datum'));
        $datum = date('Y/m/d', $time);

        if (strtotime($datum) < strtotime(date('Y/m/d'))) {

            return;
        }

        $sveSirovine = $this->sirovinaModel->getAll();
        $options = array();
        foreach ($sveSirovine as $row) {
            $options[$row->idSirovine] = $row->naziv;
        }
        $data['options'] = $options;



        $this->zahtevSirovinaModel->create($idProizv, $idSirovine, $datum, $datum, $kolicina, $rezervisano, $status);

        if ($idProizv == -1) {
            $this->showProizvodnjaPregled();
        } else {
            $this->showZahteviSirovine($idZahtevProizv);
        }
    }

}

?>
