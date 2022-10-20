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
				sheet-size: 13in 8.5in;
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
						<img src="<?php //echo get_image('orica', $results['company']->photo, 'thumb'); ?>" alt="..." width="60" />
					</td>
					<td align="center" class="border no-border-left">
						<h2 class="no-margin">
							<?php echo (isset($results['company']->company) ? strtoupper($results['company']->company) : NULL); ?>
						</h2>
						<h2 class="no-margin">
							LIST INVOICE
						</h2>
						<h4 class="no-margin">
							<?php echo $start_date . ' s/d ' . $end_date; ?>
						</h4>
					</td>
				</tr>
			</thead>
		</table>
		<table class="table">
			<tbody>
				<tr>
					<th class="text-center border">
						Invoice No
					</th>
					<th class="text-center border">
						Date
					</th>
					<th class="text-center border">
						Reseller
					</th>
					<th class="text-center border">
						Description
					</th>
					<th class="text-center border">
						Qty
					</th>
					<th class="text-center border">
						Price
					</th>
					<th class="text-center border">
						Amount
					</th>
					<th class="text-center border">
						PPN
					</th>
					<th class="text-center border">
						Total Amount
					</th>
				</tr>
				<tr bgcolor="gray">
					<th class="text-center border">
						1
					</th>
					<th class="text-center border">
						2
					</th>
					<th class="text-center border">
						3
					</th>
					<th class="text-center border">
						4
					</th>
					<th class="text-center border">
						5
					</th>
					<th class="text-center border">
						6
					</th>
					<th class="text-center border">
						7
					</th>
					<th class="text-center border">
						8
					</th>
					<th class="text-center border">
						9
					</th>
				</tr>
				<?php
					$num						= 0;
					$total_quantity				= 0;
					$total_price				= 0;
					$total_amount				= 0;
					$total_ppn					= 0;
					$total_total_amout			= 0;
					
					foreach($results['data'] as $key => $val)
					{
						echo '
							<tr>
								<td class="border">
									' . $val->invoice_no . '
								</td>
								<td class="border">
									' . date_indo($val->date) . '
								</td>
								<td class="border">
									' . $val->reseller . '
								</td>
								<td class="border">
									' . $val->description . '
								</td>
								<td class="border text-right">
									' . number_format($val->quantity) . '
								</td>
								<td class="border text-right">
									' . number_format($val->price, 2) . '
								</td>
								<td class="border text-right">
									' . number_format($val->amount, 2) . '
								</td>
								<td class="border text-right">
									' . number_format($val->ppn, 2) . '
								</td>
								<td class="text-right border">
									' . number_format($val->total_amount, 2) . '
								</td>
							</tr>
							';
						$num++;
						$total_quantity				+= $val->quantity;
						$total_price				+= $val->price;
						$total_amount				+= $val->amount;
						$total_ppn					+= $val->ppn;
						$total_total_amout			+= $val->total_amount;
					}
				?>
			</tbody>
			<tr>
				<td colspan="4" class="border" align="center">
					<b>TOTAL</b>
				</td>
				<td class="border" align="right">
					<b><?php echo number_format($total_quantity); ?></b>
				</td>
				<td class="border" align="right">
					<b><?php echo number_format($total_price, 2); ?></b>
				</td>
				<td class="border" align="right">
					<b><?php echo number_format($total_amount, 2); ?></b>
				</td>
				<td class="border" align="right">
					<b><?php echo number_format($total_ppn, 2); ?></b>
				</td>
				<td class="border" align="right">
					<b><?php echo number_format($total_total_amout, 2); ?></b>
				</td>
			</tr>
		</table>
		<htmlpagefooter name="footer">
			<table class="table">
				<tfoot>
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