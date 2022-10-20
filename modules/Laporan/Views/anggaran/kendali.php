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
				footer: html_footer;
				sheet-size: 8.5in 13in;
				margin: 50px
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
				font-family: Tahoma
			}
			.divider
			{
				display: block;
				border-top: 1px solid #000;
				border-bottom: 3px solid #000;
				padding: 1px;
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
			.text-justify
			{
				text-align: justify
			}
			table
			{
				width: 100%
			}
			th
			{
				font-weight: bold;
				font-size: 12px
			}
			td
			{
				vertical-align: top;
				font-size: 12px
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
			.no-padding-top
			{
				padding-top: 0
			}
			.no-padding-bottom
			{
				padding-bottom: 0
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
		<!-- HEADER -->
		<table class="table">
			<thead>
				<tr>
					<td width="60" class="border no-border-right">
						<img src="<?php echo get_image('variabel', $results['variabel']->logo_laporan, 'thumb'); ?>" alt="..." width="60" />
					</td>
					<td align="center" class="border no-border-left">
						<h2 class="no-margin">
							<?php echo strtoupper($results['variabel']->nama_pemda); ?>
						</h2>
						<h2 class="no-margin">
							<?php echo strtoupper($results['variabel']->nama_dinas); ?>
						</h2>
						<h3 class="no-margin">
							KENDALI BERKAS KESESUAIAN KEGIATAN PEMANFAATAN RUANG
						</h3>
					</td>
				</tr>
			</thead>
		</table>
		<br />
		<table class="table">
			<tr>
				<td style="padding-left:10px" colspan="3" class="border no-border-bottom no-padding">
					<b>DATA KRK</b>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" width="20%" class="border no-border-top no-border-bottom no-border-right no-padding">
					Nomor KRK
				</td>
				<td width="5%" align="center" class="no-padding">
					:
				</td>
				<td width="75%" class="border no-border-top no-border-bottom no-border-left no-padding">
					<b>
						<?php echo sprintf('%06d', $results['krk']->kode) . '/' . date('m', strtotime($results['krk']->timestamp)) . '.' . sprintf('%03d', $results['krk']->id) . '/DPUP/' . date('Y', strtotime($results['krk']->timestamp)); ?>
					</b>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Tanggal
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo date_indo($results['krk']->timestamp); ?>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="border no-border-top no-border-bottom no-padding">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" colspan="3" class="border no-border-top no-border-bottom no-padding">
					<b>DATA PEMOHON</b>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Nama Pemohon
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<b>
						<?php echo $results['krk']->nama_pemohon; ?>
					</b>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Alamat Pemohon
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo $results['krk']->alamat_pemohon; ?>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="border no-border-top no-border-bottom no-padding">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" colspan="3" class="border no-border-top no-border-bottom no-padding">
					<b>
						LOKASI BANGUNAN
					</b>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Alamat Lokasi
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo $results['krk']->alamat; ?>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					
				</td>
				<td align="center" class="no-padding">
					
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo $results['krk']->kelurahan; ?>,
					<?php echo $results['krk']->kecamatan; ?>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Rencana Penggunaan
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo $results['krk']->penggunaan; ?>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Klasifikasi
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo $results['krk']->klasifikasi; ?>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px" class="border no-border-top no-border-bottom no-border-right no-padding">
					Luas Lahan Rencana
				</td>
				<td align="center" class="no-padding">
					:
				</td>
				<td class="border no-border-top no-border-bottom no-border-left no-padding">
					<?php echo number_format($results['krk']->luas_tanah, 2); ?> M<sup>2</sup>
				</td>
			</tr>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<th class="text-center border" rowspan="2" width="10">
						No
					</th>
					<th class="text-center border" rowspan="2">
						Proses
					</th>
					<th class="text-center border" rowspan="2">
						Lampiran
					</th>
					<th class="text-center border" colspan="2">
						Tanggal/Paraf
					</th>
					<th class="text-center border" rowspan="2">
						Petugas
					</th>
					<th class="text-center border" rowspan="2">
						Catatan
					</th>
				</tr>
				<tr>
					<th class="text-center border">
						Dikembalikan
						<br />
						Dikoreksi
					</th>
					<th class="text-center border">
						Diterima
						<br />
						Lengkap
					</th>
				</tr>
				<tr>
					<td class="text-center border" rowspan="6">
						1
					</td>
					<td class="border" colspan="6">
						PENERIMAAN DAN VERIFIKASI KELENGKAPAN PERSYARATAN
					</td>
				</tr>
				<tr>
					<td class="border">
						a. Surat Permohonan
					</td>
					<td class="border" align="center">
						ADA
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="border">
						b. Kartu Tanda Penduduk
					</td>
					<td class="border" align="center">
						<?php echo ($results['krk']->ktp && json_decode($results['krk']->ktp) ? 'ADA' : 'TIDAK'); ?>
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="border">
						c. Surat Kepemilikan Tanah
					</td>
					<td class="border" align="center">
						<?php echo ($results['krk']->sertifikat && json_decode($results['krk']->sertifikat) ? 'ADA' : 'TIDAK'); ?>
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="border">
						d. Rekomendasi Teknis
					</td>
					<td class="border" align="center">
						<?php echo ($results['krk']->rekomendasi_teknis && json_decode($results['krk']->rekomendasi_teknis) ? 'ADA' : 'TIDAK'); ?>
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="border">
						e. Surat Kuasa
					</td>
					<td class="border" align="center">
						<?php echo ($results['krk']->surat_kuasa && json_decode($results['krk']->surat_kuasa) ? 'ADA' : 'TIDAK'); ?>
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="text-center border">
						2
					</td>
					<td class="border">
						PENGELOLA BERKAS
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="text-center border">
						3
					</td>
					<td class="border">
						PEMETAAN DAN PENYUSUNAN KKPR
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
					<td class="border" align="center">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td class="border" colspan="7">
						Sub Koordinator Perencanaan Teknis (Penata Ruang Ahli Muda)
						<br />
						<br />
						<br />
					</td>
				</tr>
				<tr>
					<td class="border" colspan="7">
						ASISTENSI KEPALA BIDANG PERENCANAAN RUANG
						<br />
						<br />
						<br />
						&nbsp;
					</td>
				</tr>
			</tbody>
		</table>
		<htmlpagefooter name="footer">
			<table class="table">
				<tfoot>
					<tr>
						<td class="v-middle">
							<img src="<?php echo $results['qrcode']; ?>" alt="..." width="80" />
						</td>
						<td colspan="2" class="v-middle text-sm">
							<b>
								Silakan pindai QRCODE di samping untuk melakukan pengecekan validitas terkait keaslian dokumen yang telah dicetak
							</b>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="text-sm text-muted">
							<i>
								<?php echo phrase('document_generated_from') . ' ' . get_setting('app_name') . ' ' ; ?>
							</i>
						</td>
						<td class="text-sm text-muted text-right print">
							<?php echo phrase('page') . ' {PAGENO} ' . phrase('of') . ' {nb}'; ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</htmlpagefooter>
	</body>
</html>