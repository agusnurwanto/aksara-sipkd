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
				font-family: Georgia
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
		<div class="text-center">
			<h2 class="no-margin">
				SURAT PERMOHONAN KRK
			</h2>
		</div>
		<br />
		<table class="table">
			<tbody>
				<tr>
					<td width="60%">
						&nbsp;
					</td>
					<td width="20">
						&nbsp;
					</td>
					<td>
						<b>
							Kepada
						</b>
					</td>
				</tr>
				<tr>
					<td width="60%">
						&nbsp;
					</td>
					<td width="30">
						Yth.
					</td>
					<td>
						<?php echo strtoupper($results['variabel']->jabatan_kepala_daerah); ?>
					</td>
				</tr>
				<tr>
					<td width="60%">
						&nbsp;
					</td>
					<td>
						Yth.
					</td>
					<td>
						<?php echo strtoupper($results['variabel']->jabatan_kepala_tata_ruang); ?>
						<br />
						Di -
						<br />
						&nbsp; &nbsp; &nbsp; &nbsp; <?php echo strtoupper($results['variabel']->nama_daerah); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<table class="table">
			<tbody>
				<tr>
					<td width="80">
						Nomor
					</td>
					<td width="20" align="center">
						:
					</td>
					<td>
						<b><?php echo sprintf('%06d', $results['krk']->kode) . '/' . date('m', strtotime($results['krk']->timestamp)) . '.' . sprintf('%03d', $results['krk']->id) . '/DPUP/' . date('Y', strtotime($results['krk']->timestamp)); ?></b>
					</td>
				</tr>
				<tr>
					<td>
						Perihal
					</td>
					<td align="center">
						:
					</td>
					<td>
						Permohonan Keterangan Rencana Kota (KRK)
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />
		<p>
			Dengan Hormat,
		</p>
		<br />
		<p>
			Yang bertanda tangan di bawah ini:
		</p>
		<table class="table">
			<tbody>
				<tr>
					<td width="20">
						1.
					</td>
					<td width="140">
						Nama Pemohon
					</td>
					<td width="20" align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->first_name . ' ' . $results['krk']->last_name; ?>
					</td>
				</tr>
				<tr>
					<td>
						2.
					</td>
					<td>
						Alamat Pemohon
					</td>
					<td align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->address; ?>
					</td>
				</tr>
				<tr>
					<td>
						3.
					</td>
					<td>
						Nomor KTP
					</td>
					<td align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->username; ?>
					</td>
				</tr>
				<tr>
					<td>
						4.
					</td>
					<td>
						Nomor Telepon / HP
					</td>
					<td align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->phone; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<br />
		<p>
			Dengan ini mengajukan permohonan Keterangan Rencana Kota (KRK) untuk lokasi lahan berikut:
		</p>
		<br />
		<table class="table">
			<tbody>
				<tr>
					<td width="20">
						1.
					</td>
					<td width="140">
						Alamat
					</td>
					<td width="20" align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->alamat; ?>
					</td>
				</tr>
				<tr>
					<td>
						2.
					</td>
					<td>
						Kelurahan
					</td>
					<td align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->village; ?>
					</td>
				</tr>
				<tr>
					<td>
						3.
					</td>
					<td>
						Kecamatan
					</td>
					<td align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->district; ?>
					</td>
				</tr>
				<tr>
					<td>
						4.
					</td>
					<td>
						Nomor Sertifikat
					</td>
					<td align="center">
						:
					</td>
					<td>
						<?php echo $results['krk']->surat_keterangan_tanah; ?>
					</td>
				</tr>
				<tr>
					<td>
						5.
					</td>
					<td>
						Koordinat GPS
					</td>
					<td align="center">
						:
					</td>
					<td>
						<table class="table">
							<tr>
								<td>
									Latitude
								</td>
								<td width="20" align="center">
									:
								</td>
								<td>
									<?php echo $results['krk']->latitude; ?>
								</td>
							</tr>
							<tr>
								<td>
									Longitude
								</td>
								<td width="20" align="center">
									:
								</td>
								<td>
									<?php echo $results['krk']->longitude; ?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<p>
			Beserta surat permohonan saya lampirkan persyaratan permohonan Kesesuaian Rencana Kota (KRK) yaitu:
		</p>
		<br />
		<table class="table">
			<tbody>
				<?php
					$ktp							= ($results['krk']->ktp ? json_decode($results['krk']->ktp) : null);
					$sertifikat						= ($results['krk']->sertifikat ? json_decode($results['krk']->sertifikat) : null);
					$rekomendasi_teknis				= ($results['krk']->rekomendasi_teknis ? json_decode($results['krk']->rekomendasi_teknis) : null);
					$akta_pendirian					= ($results['krk']->akta_pendirian ? json_decode($results['krk']->akta_pendirian) : null);
					$surat_kuasa					= ($results['krk']->surat_kuasa ? json_decode($results['krk']->surat_kuasa) : null);
					$dokumen_pendukung				= ($results['krk']->dokumen_pendukung ? json_decode($results['krk']->dokumen_pendukung) : null);
					
					$num							= 0;
					
					if($ktp)
					{
						$num++;
						
						echo '
							<tr>
								<td width="20">
									' . $num . '.
								</td>
								<td>
									Salinan KTP (berupa fotocopy / scan)
								</td>
							</tr>
						';
					}
					
					if($sertifikat)
					{
						$num++;
						
						echo '
							<tr>
								<td width="20">
									' . $num . '.
								</td>
								<td>
									Salinan Sertifikat / Surat Penyerahan / Surat Hibah (berupa fotocopy / scan)
								</td>
							</tr>
						';
					}
					
					if($rekomendasi_teknis)
					{
						$num++;
						
						echo '
							<tr>
								<td width="20">
									' . $num . '.
								</td>
								<td>
									Rekomendasi Teknis Bangunan
								</td>
							</tr>
						';
					}
					
					if($akta_pendirian)
					{
						$num++;
						
						echo '
							<tr>
								<td width="20">
									' . $num . '.
								</td>
								<td>
									Salinan Akta Pendirian Perusahaan
								</td>
							</tr>
						';
					}
					
					if($surat_kuasa)
					{
						$num++;
						
						echo '
							<tr>
								<td width="20">
									' . $num . '.
								</td>
								<td>
									Surat Kuasa
								</td>
							</tr>
						';
					}
					
					if($dokumen_pendukung)
					{
						$num++;
						
						echo '
							<tr>
								<td width="20">
									' . $num . '.
								</td>
								<td>
									Dokumen Pendukung Lain (berupa fotocopy / scan)
								</td>
							</tr>
						';
					}
				?>
			</tbody>
		</table>
		<br />
		<p>
			Demikian surat permohonan ini saya ajukan untuk dapat diproses sebagaimana dengan ketentuan yang berlaku.
		</p>
		<br />
		<table class="table">
			<tbody>
				<tr>
					<td width="60%">
						&nbsp;
					</td>
					<td align="center">
						<?php echo $results['variabel']->nama_daerah . ', ' . date_indo($results['krk']->timestamp); ?>
						<br />
						<br />
						Pemohon,
						<br />
						<br />
						<br />
						<br />
						<br />
						(...............................)
						<br />
						<?php echo $results['krk']->first_name . ' ' . $results['krk']->last_name; ?>
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
				</tfoot>
			</table>
		</htmlpagefooter>
	</body>
</html>