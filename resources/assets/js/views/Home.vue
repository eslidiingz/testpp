<template>
	<div>
		<div class="card mb-4">
			<div class="card-header bg-white">Disk Usage Overview</div>

			<div class="card-body">
				<div class="row">
					<div class="col-lg-3">Total Size:</div>
					<div class="col-lg-9">{{ totalSize(disk_overview.total_size) }}</div>
				</div>
				<div class="row">
					<div class="col-lg-3">No of files:</div>
					<div class="col-lg-9">{{ disk_overview.no_of_files }}</div>
				</div>
			</div>
		</div>

		<div class="card mb-4">
			<div class="card-header bg-white">Disk Usage Compositions</div>

			<div class="card-body">
				<table class="table" v-if="disk_composition.length">
					<tr>
						<th>Type</th>
						<th>No of files</th>
						<th>Size</th>
					</tr>
					<tr v-for="composition in disk_composition">
						<td>{{ composition.type }}</td>
						<td>{{ composition.no_of_files }}</td>
						<td>{{ totalSize(composition) }}</td>
					</tr>
				</table>
				<div v-else>No Data</div>
			</div>
		</div>
	</div>
</template>


<script>
	export default {
		data() {
			return {
				disk_overview: {
					total_size: {
						bytes: 0,
						magabytes: 0
					}
				},
				disk_composition: {}
			}
		},

		created() {
			axios.get('/api/images/diskUsage')
				.then((res) => {
					this.disk_overview = res.data.disk_overview;
					this.disk_composition = res.data.disk_composition;
				})
				.catch((error) => {
					console.log(error)
				})
		},

		methods: {
			totalSize(total_size) {
				return total_size.magabytes.toFixed(2) + ' MB (' + this.numberFormat(total_size.bytes) + ' B)';
			},
			numberFormat(number) {
			  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			}
		}
	}
</script>