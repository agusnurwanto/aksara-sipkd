<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php echo $title; ?>
		</title>
		<link rel="icon" type="image/x-icon" href="<?php echo get_image('settings', get_setting('app_icon'), 'icon'); ?>" />
		<style type="text/css">
			@page
			{
				sheet-size: 8.5in 13in;
				margin: 30px 50px
			}
			.print
			{
				display: none
			}
			@media print
			{
				.no-print
				{
					display: none
				}
				.print
				{
					display: block
				}
			}
			body
			{
				font-family: Times New Roman;
				font-size: 11px
			}
			.divider
			{
				display: block;
				border-top: 3px solid #000;
				border-bottom: 1px solid #000;
				padding: 2px;
				margin-bottom: 15px
			}
			.text-sm
			{
				font-size: 8px
			}
			.text-uppercase
			{
				text-transform: uppercase
			}
			.text-muted
			{
				color: #888
			}
			.text-left
			{
				text-align: left
			}
			.text-right
			{
				text-align: right
			}
			.text-center
			{
				text-align: center
			}
			table
			{
				width: 100%
			}
			th
			{
				font-weight: bold
			}
			td
			{
				vertical-align: top
			}
			.v-middle
			{
				vertical-align: middle
			}
			.table
			{
				border-collapse: collapse
			}
			.border
			{
				border: 1px solid #000
			}
			.no-border-left
			{
				border-left: 0
			}
			.no-border-top
			{
				border-top: 0
			}
			.no-border-right
			{
				border-right: 0
			}
			.no-border-bottom
			{
				border-bottom: 0
			}
			.no-padding
			{
				padding: 0
			}
			.no-margin
			{
				margin: 0
			}
			h1
			{
				font-size: 18px
			}
			p
			{
				margin: 0
			}
			.dotted-bottom
			{
				border-bottom: 1px dotted #000
			}
		</style>
	</head>
	<body>
		<div class="text-center">
			<img src="<?php echo get_image('variabel', $results['variabel']->logo_laporan, 'thumb'); ?>" alt="..." width="100" />
			<h3>
				<?php echo strtoupper($results['variabel']->nama_pemda); ?>
			</h3>
			<h1>
				KETERANGAN RENCANA KOTA
			</h1>
			<p>
				NOMOR: 
			</p>
		</div>
		<br />
		<p>
			Berdasarkan Peraturan Pemerintah Nomor 16 Tahun 2021 tentang Penyelenggaraan Bangunan Gedung, atas permohonan pemohon, menerbitkan Keterangan Rencana Kota kepada:
		</p>
		<br />
		<table class="table">
			<tbody>
				<tr>
					<td width="20">
						1.
					</td>
					<td width="200" colspan="3">
						Nama Pemohon
					</td>
					<td width="20">
						:
					</td>
					<td width="50%">
						<?php echo $results['krk']->first_name. ' ' . $results['krk']->last_name; ?>
					</td>
				</tr>
				<tr>
					<td>
						2.
					</td>
					<td colspan="3">
						KTP
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->username; ?>
					</td>
				</tr>
				<tr>
					<td>
						3.
					</td>
					<td colspan="3">
						Alamat
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->address; ?>
					</td>
				</tr>
				<tr>
					<td>
						4.
					</td>
					<td colspan="3">
						No. Telepon / HP
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->phone; ?>
					</td>
				</tr>
				<tr>
					<td>
						5.
					</td>
					<td colspan="5">
						Lokasi Kegiatan
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						a.
					</td>
					<td colspan="2">
						Alamat
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->alamat; ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						b.
					</td>
					<td colspan="2">
						Desa / Kelurahan
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->kelurahan; ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						c.
					</td>
					<td colspan="2">
						Kecamatan
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->kecamatan; ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						d.
					</td>
					<td colspan="2">
						Kabupaten / Kota
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->kabkot; ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						e.
					</td>
					<td colspan="2">
						Provinsi
					</td>
					<td>
						:
					</td>
					<td>
						Jawa Barat
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						f.
					</td>
					<td colspan="2">
						Koordinat Geografis yang dimohon
					</td>
					<td>
						:
					</td>
					<td>
						<?php
							echo $results['krk']->latitude . ',' . $results['krk']->longitude;
						?>
					</td>
				</tr>
				<tr>
					<td>
						6.
					</td>
					<td colspan="3">
						Luas Tanah yang dimohon
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo number_format($results['krk']->luas_tanah, 2); ?> m<sup>2</sup>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td colspan="5">
						Dinyatakan disetujui seluruhnya dengan ketentuan
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						1.
					</td>
					<td colspan="2">
						Surat Keterangan Tanah
					</td>
					<td>
						:
					</td>
					<td>
						<?php echo $results['krk']->surat_keterangan_tanah; ?>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						2.
					</td>
					<td colspan="2">
						Surat Keterangan Lain
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						3.
					</td>
					<td colspan="2">
						Luas tanah yang disetujui
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						4.
					</td>
					<td colspan="2">
						Koefisien Dasar Bangunan (KDB) maksimum
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						5.
					</td>
					<td colspan="2">
						Koefisien Lantai Bangunan (KLB) maksimum
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						6.
					</td>
					<td colspan="2">
						Koefisien Dasar Hijau (KDH) maksimum
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td width="10">
						7.
					</td>
					<td colspan="4">
						Informasi Tambahan (apabila tersedia)
					</td>
				</tr>
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
					<td width="10">
						a.
					</td>
					<td>
						Garis Sempadan Bangunan minimun
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				<tr>
					<td colspan="2">
						&nbsp;
					</td>
					<td width="10">
						b.
					</td>
					<td>
						Koefisien Tapak Basement maksimum
					</td>
					<td>
						:
					</td>
					<td>
						-
					</td>
				</tr>
				
				<tr>
					<td colspan="6">
						Dengan ketentuan:
					</td>
				</tr>
				<tr>
					<td>
						1.
					</td>
					<td colspan="5">
						Keterangan Rencana Kota merupakan keterangan bahwa rencana lokasi kegiatan telah sesuai dengan Peraturan Daerah Kota Bekasi Nomor 5 Tahun 2016 tentang Rencana Detail Tata Ruang Kota Bekasi Tahun 2015 - 2035, tidak menyatakan hak atas tanah;
					</td>
				</tr>
				<tr>
					<td>
						2.
					</td>
					<td colspan="5">
						Setelah memperoleh Keterangan Rencana Kota ini, pemohon dapat mengajukan permohonan Perizinan yang dipersyaratkan peraturan perundang-undangan;
					</td>
				</tr>
				<tr>
					<td>
						3.
					</td>
					<td colspan="5">
						Pemegang Keterangan Rencana Kota hanya dapat melakukan permohonan Perizinan sesuai dengan lokasi yang disetujui;
					</td>
				</tr>
				<tr>
					<td>
						4.
					</td>
					<td colspan="5">
						Keterangan Rencana Kota ini berlaku pada tanggal diterbitkan dan berlaku selama 3 (tiga) tahun sejak diterbitkan;
					</td>
				</tr>
				<tr>
					<td>
						5.
					</td>
					<td colspan="5">
						Terhadap kegiatan ini akan dilakukan pengawasan oleh Pemerintah Pusat atau Pemerintah Daerah sesuai ketentuan perundang-undangan;
					</td>
				</tr>
				<tr>
					<td>
						6.
					</td>
					<td colspan="5">
						Pemegang Keterangan Rencana Kota wajib mematuhi peraturan perundang-undangan yang berlaku.
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<p>
			Diterbitkan tanggal: <b>--</b>
		</p>
		<table class="table">
			<tbody>
				<tr>
					<td width="60%" rowspan="5">
						<img src="<?php echo $results['qrcode']; ?>" alt="..." width="80" />
					</td>
					<td width="20">
						<b>
							a.n.
						</b>
					</td>
					<td>
						<b>
							KEPALA DINAS TATA RUANG
							<br />
							KOTA BEKASI
						</b>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<b>
							<?php echo strtoupper($results['variabel']->jabatan_kepala_tata_ruang); ?>
						</b>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<br />
						<br />
						<br />
						<br />
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						<b>
							<u>
								( <?php echo strtoupper($results['variabel']->nama_kepala_tata_ruang); ?> )
							</u>
						</b>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						NIP. <?php echo strtoupper($results['variabel']->nip_kepala_tata_ruang); ?>
					</td>
				</tr>
			</tbody>
		</table>
		
		<pagebreak />
		
		<table class="table" style="font-family:Tahoma; font-size:10px">
			<tbody>
				<tr>
					<td colspan="3" class="border text-center" style="padding:10px">
						<h3>
							Draft Peta Keterangan Rencana Kota
						</h3>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border" style="padding: 10px">
						<p>
							Keterangan Rencana Kota (KRK) dinyatakan disetujui seluruhnya dengan pertimbangan:
						</p>
						<table class="table">
							<tr>
								<td width="10">
									1.
								</td>
								<td>
									Peraturan Daerah Kota Bekasi Nomor 5 Tahun 2016 Tentang Rencana Detail Tata Ruang Kota Bekasi;
								</td>
							</tr>
							<tr>
								<td width="10">
									2.
								</td>
								<td>
									Peraturan Walikota Bekasi Nomor 24 Tahun 2014 Tentang Garis Sempadan;
								</td>
							</tr>
							<tr>
								<td width="10">
									3.
								</td>
								<td>
									Peraturan Daerah Kota Bekasi Nomor 6 Tahun 2014 Tentang Bangunan Gedung;
								</td>
							</tr>
							<tr>
								<td width="10">
									4.
								</td>
								<td>
									Surat Pendelegasian Wewenang Nomr 065/895/Distaru.Set Tahnggal 30 Mei 2022;
								</td>
							</tr>
							<tr>
								<td width="10">
									5.
								</td>
								<td>
									Bila ada perubahan rencana tata ruang oleh pemerintah maka pemohon wajib menyesuaikan aturan yang berlaku.
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" class="border">
						SKETSA
					</td>
					<td class="border">
						LEGENDA
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border text-center">
						Peta Lokasi Kegiatan
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border">
						<?php
							$gambar					= geojson2png($results['krk']->geometry, null, null, 800, 100);
							
							if(isset($results['krk']->berkas) && $results['krk']->berkas)
							{
								$berkas				= json_decode($results['krk']->berkas);
								
								if($berkas)
								{
									foreach($berkas as $src => $alt)
									{
										$gambar		= get_image('krk', $src);
									}
								}
							}
						?>
						<img src="<?php echo $gambar; ?>" width="100%" height="100" />
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border" style="padding:10px">
						<h3>
							KETENTENTUAN KEGIATAN PEMANFAATAN RUANG
						</h3>
						<h4>
							ZONA X
						</h4>
						<p>
							Keterangan zona x
						</p>
						<br />
						<h4>
							ZONA Y
						</h4>
						<p>
							Keterangan zona y
						</p>
					</td>
				</tr>
				<tr>
					<td rowspan="2" class="border" width="50%">
						DENAH
					</td>
					<td rowspan="2" class="border text-center" width="30%">
						Koordinat batas bidang rencana
						<table class="table" style="font-size:8px">
							<tr>
								<td class="border no-border-left" width="20">
									No.
								</td>
								<td class="border">
									X
								</td>
								<td class="border no-border-right">
									Y
								</td>
							</tr>
							<tr>
								<td class="border no-border-left">
									1.
								</td>
								<td class="border">
									X
								</td>
								<td class="border no-border-right">
									Y
								</td>
							</tr>
							<tr>
								<td class="border no-border-left">
									2.
								</td>
								<td class="border">
									X
								</td>
								<td class="border no-border-right">
									Y
								</td>
							</tr>
						</table>
					</td>
					<td class="border text-center" width="20%" style="font-size:8px">
						<p>
							Kepala Sub Koordinator Pemetaan dan Pengukuran
						</p>
						<br />
						<br />
						<br />
						<br />
						<b>
							<u>
								Nama
							</u>
						</b>
						<br />
						NIP. 123
					</td>
				</tr>
				<tr>
					<td class="border text-center" style="font-size:8px">
						<p>
							a.n Kepala Dinas Tata Ruang Kota Bekasi
						</p>
						<p>
							Kepala Bidang Perencanaan
						</p>
						<br />
						<br />
						<br />
						<br />
						<b>
							<u>
								Nama
							</u>
						</b>
						<br />
						NIP. 123
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border text-center" style="padding:10px">
						"SEMATA-MATA PETUNJUK RENCANA KOTA DAN TIDAK MENYATAKAN HAK ATAS TANAH"
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border" style="padding:10px">
						<b>
							KETENTUAN KHUSUS
						</b>
						<br />
						<table class="table">
							<tr>
								<td width="10">
									1.
								</td>
								<td>
									Pemecahan persil yang dilakukan perorangan atau badan hukum minimal sebanyak 5 (lima) persil atau lebih untuk luasan lahan di bawah 3.000 m<sup>2</sup> (tiga ribu meter persegi) dan berada dalam satu kesatuan lingkungan yang diindikasikan dengan adanya jaringan jalan, wajib dilengkapi dengan rencana tapak yang harus disertakan dalam proses perizinan selanjutnya;
								</td>
							</tr>
							<tr>
								<td width="10">
									2.
								</td>
								<td>
									Penggunaan dan pembangunan sumur gali, sumur pompa, sumur artesis dilakukan setelah mendapatkan izin dari dinas yang bersangkutan;
								</td>
							</tr>
							<tr>
								<td width="10">
									3.
								</td>
								<td>
									Kawasan terbangun yang ada harus menerapkan konsep <i>zero run-off</i> dengan membuat sumur resapan sebagai bagian upaya dalam sistem pengendalian banjir;
								</td>
							</tr>
							<tr>
								<td width="10">
									4.
								</td>
								<td>
									Selain bangunan, perkerasan di dalam perpetakan kawasan terbangun yang ada harus terbuat dari bahan yang meloloskan air, seperti <i>paving block</i>.
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="border" style="padding:10px">
						Dicetak: <?php echo date_indo($tanggal_cetak); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<td class="v-middle">
						<img src="<?php echo $results['qrcode']; ?>" alt="..." width="80" />
					</td>
					<td class="v-middle text-sm">
						<b>
							Silakan pindai QRCODE di samping untuk melakukan pengecekan validitas terkait keaslian dokumen yang telah dicetak
						</b>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>