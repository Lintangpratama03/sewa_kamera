<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manage_pemasukan extends CI_Controller
{
    var $module_js = ['manage-pemasukan'];
    var $app_data = [];

    public function __construct()
    {
        parent::__construct();
        $this->_init();
        if (!$this->is_logged_in()) {
            redirect('dashboard');
        }
    }

    public function is_logged_in()
    {
        return $this->session->userdata('logged_in_1') === TRUE;
    }

    private function _init()
    {
        $this->app_data['module_js'] = $this->module_js;
    }

    public function index()
    {
        $query_menu = [
            'select' => 'id_parent,name, icon, link, type, is_admin',
            'from' => 'app_menu',
            'where' => [
                'is_admin' => '2'
            ]
        ];

        $query_dropdown = [
            'select' => 'id_parent,name,link,icon, type, is_admin',
            'from' => 'app_menu',
            'where' => [
                'type' => '2',
                'is_admin' => '2'
            ]
        ];

        $query_child = [
            'select' => 'id_parent,name,link,icon, type, is_admin',
            'from' => 'app_menu',
            'where' => [
                'type' => '3',
                'is_admin' => '2'
            ]
        ];

        $user = [
            'select' => 'a.id, a.name, a.email, a.image, a.phone_number, a.address, b.name as akses',
            'from' => 'st_user a',
            'join' => [
                'app_credential b, b.id = a.id_credential'
            ],
            'where' => [
                'a.is_deleted' => '0',
                'a.email' => $this->session->userdata('email')
            ]
        ];
        $this->app_data['get_menu'] = $this->data->get($query_menu)->result();
        $this->app_data['get_dropdown'] = $this->data->get($query_dropdown)->result();
        $this->app_data['get_child'] = $this->data->get($query_child)->result();
        $this->app_data['user'] = $this->data->get($user)->row_array();
        $this->app_data['title'] = 'Kelola pemasukan';
        $this->load->view('template-mitra/start', $this->app_data);
        $this->load->view('template-mitra/header', $this->app_data);
        $this->load->view('front_page/manage_pemasukan');
        $this->load->view('template-mitra/footer');
        $this->load->view('template-mitra/end');
        $this->load->view('js-custom', $this->app_data);
    }
    public function get_data()
    {
        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id_mitra =  $data['user']['id'];
        $query = "SELECT 
                t.id,
                u.name AS nama_pelanggan,
                t.tgl_transaksi,
                t.total_harga AS total_transaksi,
                IFNULL(d.total, 0) AS total_denda,
                (t.total_harga + IFNULL(d.total, 0)) AS total_pemasukan
            FROM 
                transaksi t
            LEFT JOIN
                detail_denda d ON t.id = d.id_transaksi
            LEFT JOIN
                st_user u ON t.id_user = u.id
            WHERE 
                t.status = 'selesai'  
                AND t.is_deleted = 0
                AND t.id_mitra = ?
            ORDER BY 
                t.tgl_transaksi DESC";
        $result = $this->db->query($query, array($id_mitra))->result();
        echo json_encode($result);
    }
    public function generate_pdf()
    {
        $this->load->library('pdf');

        $where = array('email' => $this->session->userdata('email'));
        $data['user'] = $this->data->find('st_user', $where)->row_array();
        $id_mitra =  $data['user']['id'];

        $year = $this->input->get('year');
        $month = $this->input->get('month');

        $query = "SELECT 
                t.id,
                u.name AS nama_pelanggan,
                t.tgl_transaksi,
                t.total_harga AS total_transaksi,
                IFNULL(d.total, 0) AS total_denda,
                (t.total_harga + IFNULL(d.total, 0)) AS total_pemasukan
            FROM 
                transaksi t
            LEFT JOIN
                detail_denda d ON t.id = d.id_transaksi
            LEFT JOIN
                st_user u ON t.id_user = u.id
            WHERE 
                t.status = 'selesai'  
                AND t.is_deleted = 0
                AND t.id_mitra = ?";

        if ($year) {
            $query .= " AND YEAR(t.tgl_transaksi) = ?";
        }
        if ($month) {
            $query .= " AND MONTH(t.tgl_transaksi) = ?";
        }
        $query .= " ORDER BY t.tgl_transaksi DESC";

        $params = array($id_mitra);
        if ($year) $params[] = $year;
        if ($month) $params[] = $month;

        $result = $this->db->query($query, $params)->result_array();

        // Create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Sewa Kamera');
        $pdf->SetTitle('Transaction History');
        $pdf->SetSubject('Transaction History');
        $pdf->SetKeywords('TCPDF, PDF, transaction, history');

        // Set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Transaction History', 'Generated on ' . date('Y-m-d H:i:s'));

        // Set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // Add a page
        $pdf->AddPage();

        // Create the table content
        $html = '<table border="1" cellpadding="4">
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Transaksi</th>
            <th>Total Transaksi</th>
            <th>Total Denda</th>
            <th>Total Pemasukan</th>
        </tr>';

        $no = 1;
        $total_pemasukan = 0;
        foreach ($result as $row) {
            $html .= '<tr>
            <td>' . $no++ . '</td>
            <td>' . $row['nama_pelanggan'] . '</td>
            <td>' . date('d/m/Y', strtotime($row['tgl_transaksi'])) . '</td>
            <td align="right">Rp ' . number_format($row['total_transaksi'], 0, ',', '.') . '</td>
            <td align="right">Rp ' . number_format($row['total_denda'], 0, ',', '.') . '</td>
            <td align="right">Rp ' . number_format($row['total_pemasukan'], 0, ',', '.') . '</td>
        </tr>';
            $total_pemasukan += $row['total_pemasukan'];
        }

        $html .= '<tr>
        <td colspan="5" align="right"><strong>Total Pemasukan:</strong></td>
        <td align="right"><strong>Rp ' . number_format($total_pemasukan, 0, ',', '.') . '</strong></td>
    </tr>';

        $html .= '</table>';

        // Print the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and output PDF document
        $pdf->Output('transaction_history.pdf', 'D');
    }
}
