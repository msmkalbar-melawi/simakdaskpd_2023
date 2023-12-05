<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class LraController extends CI_Controller
{

    function __contruct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['page_title'] = 'LRA JKN BOK';
        $this->template->set('title', 'LRA JKN BOK');
        $this->template->load('template', 'jkn/lra/index', $data);
    }
    function config_skpd()
    {
        $skpd     = $this->session->userdata('kdskpd');
        $sql = "SELECT a.kd_skpd as kd_skpd,a.nm_skpd as nm_skpd FROM ms_skpd_jkn a WHERE a.kd_skpd ='$skpd'";
        $query1 = $this->db->query($sql);
        $ii = 0;
        foreach ($query1->result_array() as $resulte) {
            $result = array(
                'id' => $ii,
                'kd_skpd' => $resulte['kd_skpd'],
                'nm_skpd' => $resulte['nm_skpd']
            );
            $ii++;
        }
        echo json_encode($result);
        // $query1->free_result();
    }
    public function ttd()
    {
        $kd_skpd = $this->session->userdata('kdskpd');
        $sql = "SELECT * FROM ms_ttd WHERE kd_skpd= '$kd_skpd' and kode in ('KPA','PA')";

        $mas = $this->db->query($sql);
        $result = array();
        $ii = 0;
        foreach ($mas->result_array() as $resulte) {

            $result[] = array(
                'id' => $ii,
                'nip' => $resulte['nip'],
                'id_ttd' => $resulte['id'],
                'nama' => $resulte['nama'],
                'jabatan' => $resulte['jabatan']
            );
            $ii++;
        }

        echo json_encode($result);
        $mas->free_result();
    }

    public function laporan()
    {
        $kd_skpd = $this->session->userdata('kdskpd');
        $tahun  = $this->session->userdata('pcThang');
        $print = $_GET['ctk'];
        $periode1 = $_GET['periode1'];
        $periode2 = $_GET['periode2'];
        $tgl_ttd = $_GET['tgl_ttd'];
        $ttd = $_GET['ttd'];
        $jenis = $_GET['jenis'];
        $dataisian = true;
        $datattd = $this->db->query("SELECT * FROM ms_ttd WHERE kd_skpd='$kd_skpd' AND id='$ttd'")->row();
        // echo ($periode2);


        if ($jenis == 'jkn') {
            $judul = 'KAPITASI JKN';
            $dataisian = $this->db->query("SELECT * FROM (
                SELECT '1' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM(
                -- ms rek 2
                SELECT  a.kd_skpd as kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan nm_sub_kegiatan, LEFT(a.kd_rek6,2) as kd_rek6, c.nm_rek2 as nm_rek6, SUM(a.nilai) as nilai FROM jkn_trdrka a INNER JOIN jkn_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek2 c ON c.kd_rek2=LEFT(a.kd_rek6,2) WHERE a.jenis IN('1') GROUP BY LEFT(a.kd_rek6,2), c.nm_rek2, a.kd_skpd,a.nm_sub_kegiatan,a.kd_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,2) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_trdtransout a INNER JOIN jkn_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,2),a.kd_sub_kegiatan
                UNION ALL
                SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,2) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_tr_terima a WHERE a.tgl_terima BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,2),a.kd_sub_kegiatan
                ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek 3
                UNION ALL
                SELECT '2' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM(
                SELECT  a.kd_skpd as kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,4) as kd_rek6, c.nm_rek3 as nm_rek6, SUM(a.nilai) as nilai FROM jkn_trdrka a INNER JOIN jkn_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek3 c ON c.kd_rek3=LEFT(a.kd_rek6,4) WHERE a.jenis IN('1') GROUP BY LEFT(a.kd_rek6,4), c.nm_rek3, a.kd_skpd,a.kd_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,4) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_trdtransout a INNER JOIN jkn_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,4),a.kd_sub_kegiatan 
                UNION ALL
                SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,4) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_tr_terima a WHERE a.tgl_terima BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,4),a.kd_sub_kegiatan
                ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek 4
                UNION ALL
                SELECT '3' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM(
                SELECT  a.kd_skpd as kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,6) as kd_rek6, c.nm_rek4 as nm_rek6, SUM(a.nilai) as nilai FROM jkn_trdrka a INNER JOIN jkn_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek4 c ON c.kd_rek4=LEFT(a.kd_rek6,6) WHERE a.jenis IN('1') GROUP BY LEFT(a.kd_rek6,6), c.nm_rek4, a.kd_skpd,a.kd_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,6) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_trdtransout a INNER JOIN jkn_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY  a.kd_skpd,LEFT(a.kd_rek6,6),a.kd_sub_kegiatan
                UNION ALL
                SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,6) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_tr_terima a WHERE a.tgl_terima BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,6),a.kd_sub_kegiatan
                ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek5
                UNION ALL
                SELECT '4' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM(
                SELECT  a.kd_skpd as kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,8) as kd_rek6, c.nm_rek5 as nm_rek6, SUM(a.nilai) as nilai FROM jkn_trdrka a INNER JOIN jkn_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek5 c ON c.kd_rek5=LEFT(a.kd_rek6,8) WHERE a.jenis IN('1') GROUP BY LEFT(a.kd_rek6,8), c.nm_rek5, a.kd_skpd, a.kd_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,8) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_trdtransout a INNER JOIN jkn_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,8),a.kd_sub_kegiatan
                UNION ALL
                SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,8) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_tr_terima a WHERE a.tgl_terima BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,8),a.kd_sub_kegiatan
                ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek 6
                UNION ALL
                SELECT '5'as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6,a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM(SELECT a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, a.nilai FROM jkn_trdrka a INNER JOIN jkn_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis WHERE a.jenis IN('1') )a LEFT JOIN (SELECT a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, SUM(a.nilai) as nilai FROM jkn_trdtransout a INNER JOIN jkn_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6
                UNION ALL
                SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, a.kd_rek6 as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM jkn_tr_terima a WHERE a.tgl_terima BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,a.kd_rek6,a.kd_sub_kegiatan
                ) x ON x.kd_sub_kegiatan=a.kd_sub_kegiatan AND x.kd_rek6=a.kd_rek6 AND x.kd_skpd=a.kd_skpd) s WHERE s.kd_skpd='$kd_skpd' ORDER BY s.kd_sub_kegiatan,s.kd_rek6");
            $nm_skpd = $this->db->query("SELECT nm_skpd FROM ms_skpd_jkn WHERE kd_skpd='$kd_skpd'")->row();
        } else if ($jenis == 'bok') {
            $judul = 'BOK';
            $dataisian = $this->db->query("SELECT * FROM ( SELECT '1' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM( 
                -- ms rek 2 
                SELECT a.kd_skpd as kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan as nm_sub_kegiatan, LEFT(a.kd_rek6,2) as kd_rek6, c.nm_rek2 as nm_rek6, SUM(a.nilai) as nilai FROM bok_trdrka a INNER JOIN bok_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek2 c ON c.kd_rek2=LEFT(a.kd_rek6,2) WHERE a.jenis IN('3') GROUP BY LEFT(a.kd_rek6,2), c.nm_rek2, a.kd_skpd,a.kd_sub_kegiatan,a.nm_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,2) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM bok_trdtransout a INNER JOIN bok_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,2),a.kd_sub_kegiatan ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek 3 
                UNION ALL SELECT '2' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM( SELECT a.kd_skpd as kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, a.nm_sub_kegiatan as nm_sub_kegiatan, LEFT(a.kd_rek6,4) as kd_rek6, c.nm_rek3 as nm_rek6, SUM(a.nilai) as nilai FROM bok_trdrka a INNER JOIN bok_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek3 c ON c.kd_rek3=LEFT(a.kd_rek6,4) WHERE a.jenis IN('3') GROUP BY LEFT(a.kd_rek6,4), c.nm_rek3, a.kd_skpd,a.kd_sub_kegiatan,a.nm_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,4) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM bok_trdtransout a INNER JOIN bok_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,4),a.kd_sub_kegiatan ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek 4 
                UNION ALL SELECT '3' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM( SELECT a.kd_skpd as kd_skpd, a.kd_sub_kegiatan kd_sub_kegiatan, a.nm_sub_kegiatan as nm_sub_kegiatan, LEFT(a.kd_rek6,6) as kd_rek6, c.nm_rek4 as nm_rek6, SUM(a.nilai) as nilai FROM bok_trdrka a INNER JOIN bok_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek4 c ON c.kd_rek4=LEFT(a.kd_rek6,6) WHERE a.jenis IN('3') GROUP BY LEFT(a.kd_rek6,6), c.nm_rek4, a.kd_skpd,a.kd_sub_kegiatan,a.nm_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, '' nm_sub_kegiatan, LEFT(a.kd_rek6,6) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM bok_trdtransout a INNER JOIN bok_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,6),a.kd_sub_kegiatan ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek5 
                UNION ALL SELECT '4' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, a.nilai as anggaran, ISNULL(x.nilai,0) as realisasi FROM( SELECT a.kd_skpd as kd_skpd, a.kd_sub_kegiatan as kd_sub_kegiatan, a.nm_sub_kegiatan as nm_sub_kegiatan, LEFT(a.kd_rek6,8) as kd_rek6, c.nm_rek5 as nm_rek6, SUM(a.nilai) as nilai FROM bok_trdrka a INNER JOIN bok_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis LEFT JOIN ms_rek5 c ON c.kd_rek5=LEFT(a.kd_rek6,8) WHERE a.jenis IN('3') GROUP BY LEFT(a.kd_rek6,8), c.nm_rek5, a.kd_skpd,a.kd_sub_kegiatan,a.nm_sub_kegiatan)a LEFT JOIN( SELECT a.kd_skpd, a.kd_sub_kegiatan kd_sub_kegiatan, a.nm_sub_kegiatan as nm_sub_kegiatan, LEFT(a.kd_rek6,8) as kd_rek6, '' as nm_rek6,SUM(a.nilai) as nilai FROM bok_trdtransout a INNER JOIN bok_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd,LEFT(a.kd_rek6,8),a.kd_sub_kegiatan,a.nm_sub_kegiatan ) x ON x.kd_skpd=a.kd_skpd AND x.kd_rek6=a.kd_rek6 AND x.kd_sub_kegiatan=a.kd_sub_kegiatan
                -- ms rek 6 
                UNION ALL 
                SELECT '5' as urut, a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6,a.nm_rek6, SUM(ISNULL(a.nilai,0)) as anggaran, SUM(ISNULL(x.nilai,0)) as realisasi FROM(SELECT a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, SUM(a.nilai) as nilai FROM bok_trdrka a INNER JOIN bok_trhrka b ON b.kd_skpd=a.kd_skpd AND b.no_bukti=a.no_bukti AND a.jenis=b.jenis WHERE a.jenis IN('3') GROUP BY a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6 )a LEFT JOIN (SELECT a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6, SUM(a.nilai) as nilai FROM bok_trdtransout a INNER JOIN bok_trhtransout b ON b.kd_skpd=a.kd_skpd AND a.no_bukti=b.no_bukti AND a.no_sp2d=b.no_sp2d WHERE b.tgl_bukti BETWEEN '$periode1' AND '$periode2' GROUP BY a.kd_skpd, a.kd_sub_kegiatan, a.nm_sub_kegiatan, a.kd_rek6, a.nm_rek6) x ON x.kd_sub_kegiatan=a.kd_sub_kegiatan AND x.kd_rek6=a.kd_rek6 AND x.kd_skpd=a.kd_skpd GROUP BY a.kd_skpd, a.kd_sub_kegiatan ,a.nm_sub_kegiatan,a.kd_rek6,a.nm_rek6
                ) s WHERE s.kd_skpd='$kd_skpd' ORDER BY s.kd_sub_kegiatan,s.kd_rek6");
            $nm_skpd = $this->db->query("SELECT nm_skpd FROM ms_skpd_jkn WHERE kd_skpd='$kd_skpd'")->row();
        }

        $cRet = '';

        $cRet .= "<table style=\"border-collapse:collapse;font-family: Times New Roman; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
            <td align=\"center\" style=\"font-size:14px\" width=\"93%\">&nbsp;</td>
            </tr>
            <tr>
            <td align=\"center\" style=\"font-size:14px\" width=\"93%\">&nbsp;&nbsp;&nbsp;&nbsp;<strong>PEMERINTAH KABUPATEN MELAWI </strong></td></tr>
            <tr>
            <td align=\"center\" style=\"font-size:14px\" >&nbsp;&nbsp;&nbsp;&nbsp;<strong>PERIODE ".strtoupper($this->tukd_model->tanggal_format_indonesia($periode1)) ." S.D ".strtoupper($this->tukd_model->tanggal_format_indonesia($periode2)) ."<br>TAHUN ANGGARAN $tahun</strong></td></tr>
            <tr>
            <td align=\"center\" style=\"font-size:14px\" >&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;</strong></td></tr>
            </table>
            ";

        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\">
        <tr>
            <td align=\"center\" colspan=\"16\" style=\"font-size:14px;border: solid 1px white;\"><b>LAPORAN REALISASI DANA $judul PADA FKTP " . strtoupper($nm_skpd->nm_skpd) . "</b></td>
        </tr>
        <tr>
            <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
            <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
        </tr>
        <tr>
            <td align=\"left\" colspan=\"12\" style=\"font-size:12px;border: solid 1px white;\">&nbsp;</td>
            <td align=\"left\" colspan=\"4\" style=\"font-size:12px;border: solid 1px white;\"></td>
        </tr>
        </table>
        <table style=\"border-collapse:collapse; border-color: black;\" width=\"100%\" align=\"center\" border=\"1\" cellspacing=\"1\" cellpadding=\"1\" >
        <thead> 
        <tr>
        <td align=\"center\" width=\"20%\" style=\"font-size:12px;font-weight:bold;\">Sub Kegiatan</td>
            <td align=\"center\" width=\"10%\" style=\"font-size:12px;font-weight:bold;\">Kode Rekening</td>
            <td align=\"center\" width=\"28%\" style=\"font-size:12px;font-weight:bold\">Nama Rekening</td>

            <td align=\"center\" width=\"12%\" style=\"font-size:12px;font-weight:bold\">Jumlah Anggaran(Rp)</td>
            <td align=\"center\" width=\"12%\" style=\"font-size:12px;font-weight:bold\">Jumlah Realisasi(Rp)</td>
            <td align=\"center\" width=\"10%\" style=\"font-size:12px;font-weight:bold\">Selisih/Kurang</td>
            <td align=\"center\" width=\"5%\" style=\"font-size:12px;font-weight:bold\">%</td>
        </tr>
        <tr>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">1</td>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">1</td>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">2</td>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">3</td>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">4</td>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">5</td>
        <td align=\"center\"  style=\"font-size:12px;border-top:solid 1px black\">6</td>
        </tr>
        </thead>";
        $persen = 0;
        $totalanggaran = 0;
        $totalrealisasi = 0;
        $persentot = 0;
        // $hasill=0;
        // $dataaaaaaa=0;
        foreach ($dataisian->result_array() as $resulte) {
            //$persen = $resulte['realisasi'] / $resulte['anggaran'] * 100 ;
            $persen=($resulte['realisasi']!=0)?($resulte['realisasi']/$resulte['anggaran']) * 100:0;

            $hasill = ($resulte['anggaran'] < $resulte['realisasi']) ?  '(' . number_format($resulte['realisasi'], 2, ",", ".") . ')' : number_format($resulte['realisasi'], 2, ",", ".");
            // " . number_format($resulte['anggaran'] - $resulte['realisasi'], 2, ",", ".") . "
            $hasill1 = ($resulte['anggaran'] < $resulte['realisasi']) ?  '(' . number_format($resulte['anggaran'] - $resulte['realisasi'], 2, ",", ".") . ')' : number_format($resulte['anggaran'] - $resulte['realisasi'], 2, ",", ".");
            $hasil = ($resulte['urut'] == '1') ? $resulte['kd_sub_kegiatan'] . '<br>' . $resulte['nm_sub_kegiatan'] : null;
            if ($resulte['urut'] == '1' && substr($resulte['kd_rek6'], 0, 1) == '5') {
                $totalanggaran += $resulte['anggaran'];
                $totalrealisasi += $resulte['realisasi'];
                $persentot = $totalrealisasi / $totalanggaran * 100;
            }
            $cRet .= "<tr>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\"> $hasil</td>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . $resulte['kd_rek6'] . "</td>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . $resulte['nm_rek6'] . "</td>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . number_format($resulte['anggaran'], 2, ",", ".") . "</td>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">$hasill</td>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">$hasill1</td>
            <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . number_format($persen, 2, ",", ".") . "</td>
            </tr>";
        }
        $cRet .= "<tr>
        <td align=\"left\" colspan=\"3\" style=\"font-size:12px;border-top:solid 1px black\">Total</td>
        <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . number_format($totalanggaran, 2, ",", ".") . "</td>
        <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . number_format($totalrealisasi, 2, ",", ".") . "</td>
        <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . number_format($totalanggaran - $totalrealisasi, 2, ",", ".") . "</td>
        <td align=\"left\"  style=\"font-size:12px;border-top:solid 1px black\">" . number_format($persentot, 2, ",", ".") . "</td>
        </tr>";
        $cRet .= " </table>";


        $cRet .= "<table style=\"border-collapse:collapse;\" width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
        <tr>
        <td align=\"center\" width=\"50%\"></td>
        <td align=\"center\" width=\"50%\">Nanga Pinoh, " . $this->tukd_model->tanggal_format_indonesia($tgl_ttd) . "</td>
        </tr>
        <tr>
        <td align=\"center\" width=\"50%\"></td>
        <td align=\"center\" width=\"50%\">$datattd->jabatan</td>
        </tr>
        <tr>
        <td align=\"center\" width=\"50%\">&nbsp;</td>
        <td align=\"center\" width=\"50%\"></td>
        </tr>
        <tr>
        <td align=\"center\" width=\"50%\">&nbsp;</td>
        <td align=\"center\" width=\"50%\"></td>
        </tr>

        <tr>
                <td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"><b><u></u></b><br></td>
                <td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"><b><u>$datattd->nama</u></b><br></td>
            </tr>
            <tr>
                <td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\"></td>
                 <td align=\"center\" width=\"50%\" style=\"font-size:14px;border: solid 1px white;\">NIP.$datattd->nip</td>
            </tr>
            </table>";

        if ($print == 0) {
            $data['prev'] = $cRet;
            echo ("<title>LRA</title>");
            echo $cRet;
        } else if ($print == '1') {
            $this->support->_mpdf_margin('', $cRet, 10, 10, 10, '0');
        } else if ($print == '2') {
            echo 'Sedang Perbaikan';
        } else {
        }
    }
}
