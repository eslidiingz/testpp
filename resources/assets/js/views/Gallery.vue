<!-- Styles -->
<style lang="scss">
	.dropzone {
		border: 2px dashed lightgray;
		padding: 10rem;
		text-align: center;
		color: gray;
		display: block;

		input {
			display: none;
		}
	}

	.img-container {
		position: relative;

		.button {
			position: absolute;
			top: 50%;
			left: 0;
			right: 0;
			display: none;
			z-index: 1;
		}

		&:hover {
			&:after {
				content: "";
		    display: block;
		    background-color: rgba(0, 0, 0, 0.3);
		    position: absolute;
		    top: 0;
		    bottom: 0;
		    left: 0;
		    right: 0;
			}

			.button {
				display: block;
			}
		}
	}
</style>


<template>
	<div>
		<div class="card mb-4">
			<div class="card-header bg-white">Gallery</div>

			<div class="card-body">
				<!-- Drag & Drop zone -->
				<form class="mb-4">
					<label for="uploads" id="dropzone" class="dropzone">
						<i class="fas fa-cloud-upload-alt fa-4x"></i>
						<div>Drop files here or click to choose file...</div>
						<input type="file" id="uploads" multiple @change="onChange($event.target.files)" accept="image/*">
					</label>
				</form>


				<!-- Results -->
				<div class="results">
					<div class="row">
						<div class="col-lg-4 mb-4" v-for="image in images">
							<div class="img-container text-center">
								<img class="img-fluid" :src="fileLink(image)">
								<div class="button">
									<a class="btn btn-primary" :href="fileLink(image)" data-lightbox="gallery"><i class="fa fa-search"></i></a>
									<button class="btn btn-danger" @click="deleteImage(image)"><i class="fa fa-trash"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<!-- Scripts -->
<script>
	export default {
		name: 'gallery',
		data() {
			return {
				images: [],
				attachments: [],
				percent: 0,
				form: new FormData,
			}
		},
		created() {
			this.fetchData();
		},

		methods: {
			fetchData() {
				axios.get('/api/images')
					.then((res) => {
						this.images = res.data;
					})
					.catch((error) => {
						console.log(error)
					})
			},

			onChange(event) {
				let selectedFile = event;

				if ( !selectedFile.length ) {
					return false;
				}

				for ( let i = 0; i < selectedFile.length; i++) {
					this.attachments.push(selectedFile[i])
				}

				this.upload();
			},

			upload() {
				this.form.delete('images[]');
				for ( let i = 0; i < this.attachments.length; i++) {
					this.form.append('images[]', this.attachments[i]);
				}

				const config = {
					headers: { 'Content-Type': 'multipart/form-data'},
					onUploadProgress: uploadEvent => {
						this.percent = Math.round(uploadEvent.loaded / uploadEvent.total * 100);
					}
				};

				axios.post('/api/images', this.form, config)
					.then((res) => {
						this.attachments = [];
						this.fetchData();
					})
					.catch((error) => {
						console.log(error)
					})
			},

			fileLink(image) {
				return '/uploads/' + image.filename;
			},

			deleteImage(image) {
				axios.delete('/api/images/' + image.id)
					.then((res) => {
						this.fetchData();
					})
			}
		},

		mounted() {
			let self = this;
      document.querySelector("#dropzone").addEventListener("dragenter", function (e) {
      });

      document.querySelector("#dropzone").addEventListener("dragleave", function (e) {
        e.preventDefault();
        this.style.backgroundColor = "transparent";
      });

      document.querySelector("#dropzone").addEventListener("dragover", function (e) {
        e.preventDefault();
        this.style.backgroundColor = "#eaeaea";
      });

      document.querySelector("#dropzone").addEventListener("drop", function (e) {
        e.preventDefault();
        this.style.backgroundColor = "transparent";

        var files = e.dataTransfer.files;
        self.onChange(files);
      });
		}
	}
</script>