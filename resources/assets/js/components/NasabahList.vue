<template>
    <div>
        <div v-if="update" class="alert alert-info alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>
            <strong>Berhasil!</strong> Data nasabah telah di update!
        </div>

        <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
                <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                    <span class="text-uppercase page-subtitle">Overview</span>
                    <h3 class="page-title">Nasabah</h3>
                </div>
            </div>
            <!-- End Page Header -->
            <!-- Default Light Table -->
            <div class="row">
                <div class="col">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <h6 class="m-0 d-flex justify-content-between">
                                <button type="button" class="btn btn-sm btn-pill btn-outline-primary" data-toggle="modal"
                                    data-target="#modalNasabah" @click="edit = true">
                                    <i class="material-icons mr-1">person</i>Tambah</button>
                                <div>
                                    <input type="text" placeholder="Pencarian" class="form-control" v-model="pencarian">
                                </div>
                            </h6>
                        </div>
                        <div class="card-body p-0 pb-3 text-center">
                            <table class="table mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="border-0">No Anggota</th>
                                        <th scope="col" class="border-0">Nama</th>
                                        <th scope="col" class="border-0">Email</th>
                                        <th scope="col" class="border-0">Alamat</th>
                                        <th scope="col" class="border-0">Kelamin</th>
                                        <th scope="col" class="border-0">Status</th>
                                        <th scope="col" class="border-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="nasabah in nasabahs" :key="nasabah.id">
                                        <td><img :src="'images/'+nasabah.foto" class="user-avatar rounded-circle mr-3"
                                                width="40px" height="40px">{{ nasabah.no_anggota }}</td>
                                        <td>{{ nasabah.name }}</td>
                                        <td>{{ nasabah.email }}</td>
                                        <td>{{ nasabah.alamat }}</td>
                                        <td>{{ nasabah.kelamin }}</td>
                                        <td>{{ nasabah.status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                        <td>
                                            <a href="#" class="" v-on:click="editNasabah(nasabah.id)">
                                                <i class="material-icons mr-1">edit</i>
                                            </a>
                                            <a href="#" class="" v-on:click="deleteNasabah(nasabah.id, nasabah.name)">
                                                <i class="material-icons mr-1">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="float-right mr-2 mt-2">
                                <vue-pagination :data="nasabah" v-on:pagination-change-page="getNasabah" :limit="1"></vue-pagination>
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="modalNasabah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form v-on:submit.prevent="edit ? saveForm() : updateForm()">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ edit ? 'Tambah Nasabah' :
                                                'Edit Nasabah' }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Nama Nasabah">Nama Nasabah</label>
                                                        <input type="text" v-model="form.name" id="Nama Nasabah" class="form-control"
                                                            :class="errors.name ? 'is-invalid': ''">
                                                        <div v-if="errors.name" class="invalid-feedback">{{
                                                            errors.name[0]
                                                            }}</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Email">Email</label>
                                                        <input type="email" v-model="form.email" id="Email" class="form-control"
                                                            :class="errors.email ? 'is-invalid': ''">
                                                        <div v-if="errors.email" class="invalid-feedback">{{
                                                            errors.email[0] }}</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Password">Password</label>
                                                        <input type="password" id="Password" v-model="form.password"
                                                            class="form-control" :class="errors.password ? 'is-invalid': ''">
                                                        <div v-if="errors.password" class="invalid-feedback">{{
                                                            errors.password[0] }}</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Jenis Kelamin">Jenis Kelamin</label>
                                                        <br>
                                                        <input type="radio" id="Laki-Laki" value="Laki-Laki" v-model="form.kelamin">
                                                        <label for="Laki-Laki">Laki-Laki</label>
                                                        <br>
                                                        <input type="radio" id="Perempuan" value="Perempuan" v-model="form.kelamin">
                                                        <label for="Perempuan">Perempuan</label>
                                                        <div v-if="errors.kelamin" class="invalid-feedback">{{
                                                            errors.kelamin[0] }}</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Agama">Agama</label>
                                                        <select id="Agama" v-model="form.agama" class="form-control"
                                                            :class="errors.agama ? 'is-invalid': ''">
                                                            <option v-for="agama in options.agama" :key="agama.id">{{
                                                                agama.name }}</option>
                                                        </select>
                                                        <div v-if="errors.agama" class="invalid-feedback">{{
                                                            errors.agama[0] }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="Identitas">Identitas</label>
                                                                <select v-model="form.identitas" id="Identitas" class="form-control"
                                                                    :class="errors.identitas ? 'is-invalid': ''">
                                                                    <option v-for="identitas in options.identitas" :key="identitas.id">{{
                                                                        identitas.name }}</option>
                                                                </select>
                                                                <div v-if="errors.identitas" class="invalid-feedback">{{
                                                                    errors.identitas[0] }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="No Identitas">No Identitas</label>
                                                                <input type="number" id="No Identitas" class="form-control"
                                                                    v-model="form.no_identitas" :class="errors.no_identitas ? 'is-invalid': ''">
                                                                <div v-if="errors.no_identitas" class="invalid-feedback">{{
                                                                    errors.no_identitas[0] }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Alamat">Alamat</label>
                                                        <textarea id="Alamat" cols="10" v-model="form.alamat" class="form-control"
                                                            :class="errors.alamat ? 'is-invalid': ''"></textarea>
                                                        <div v-if="errors.alamat" class="invalid-feedback">{{
                                                            errors.alamat[0]
                                                            }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="Foto">Foto</label>
                                                        <div v-if="!form.foto">
                                                            <input type="file" class="form-control" :class="errors.foto ? 'is-invalid': ''"
                                                                @change="onFileChange">
                                                        </div>
                                                        <div v-else>
                                                            <img :src="form.foto" class="form-control" :class="errors.foto ? 'is-invalid': ''" />
                                                            <button @click="removeImage">Remove Image</button>
                                                        </div>
                                                        <div v-if="errors.foto" class="invalid-feedback">{{
                                                            errors.foto[0]
                                                            }}</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select v-model="form.status" id="status" class="form-control" :class="errors.status ? 'is-invalid': ''">
                                                            <option v-for="status in options.status" :key="status.id" :value="status.value">{{ status.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Default Light Table -->

        </div>

    </div>




</template>

<script>
    export default {
        name: 'nasabah-list',
        data() {
            return {
                errors: [],
                nasabahs: [],
                nasabah: {},
                pencarian: '',
                edit: false,
                update: false,

                options: {
                    selectUser: [],
                    agama: [{
                            name: 'Islam',
                            value: 'Islam'
                        },
                        {
                            name: 'Kristen',
                            value: 'Kristen'
                        },
                        {
                            name: 'Hindu',
                            value: 'Hindu'
                        },
                        {
                            name: 'Protestan',
                            value: 'Protestan'
                        },
                        {
                            name: 'Katolik',
                            value: 'Katolik'
                        },
                    ],
                    identitas: [{
                            name: 'KTP',
                            value: 'KTP'
                        },
                        {
                            name: 'SIM',
                            value: 'SIM'
                        },
                    ],
                    status: [
                        {
                            name: 'Aktif',
                            value: 1
                        },
                        {
                            name: 'Tidak Aktif',
                            value: 0
                        },
                    ],
                },

                form: {
                    id: '',
                    name: '',
                    email: '',
                    status: 1,
                    kelamin: '',
                    password: '',
                    no_anggota: 'no_anggota',
                    agama: '',
                    identitas: '',
                    no_identitas: '',
                    alamat: '',
                    foto: '',
                }
            }
        },

        mounted() {
            this.getNasabah()
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
                this.getNasabah()
            }
        },

        methods: {
            getNasabah(page = 1) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('api/nasabah?q=' + this.pencarian + '&page=' + page)
                    .then(function (response) {
                        this.nasabahs = response.data.data
                        this.nasabah = response.data
                    }.bind(this))
                    .catch(function (error) {
                        alert("Could not load nasabah")
                    }.bind(this));
            },

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.foto = e.target.result;
                };
                reader.readAsDataURL(file);
            },

            removeImage: function (e) {
                this.form.foto = '';
            },

            saveForm() {
                axios.post('nasabah', this.form)
                    .then(function (response) {
                        $('#modalNasabah').modal('hide')
                        this.getNasabah()
                        alert('Berhasil Simpan Nasabah')
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            deleteNasabah(id, name) {
                if (confirm("Yakin Ingin Menghapus Data Nasabah " + name + " ?")) {
                    axios.delete('api/nasabah/' + id)
                        .then(function (response) {
                            alert("Berhasil Menghapus Nasabah " + name)
                            this.getNasabah()
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error)
                        }.bind(this));
                }
            },

            editNasabah(id) {
                axios.get('api/nasabah/' + id)
                    .then(function (response) {
                        this.edit = false
                        this.update = false
                        this.form = response.data
                        $('#modalNasabah').modal('show')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            updateForm() {
                axios.patch('nasabah/' + this.form.id, this.form)
                    .then(function (response) {
                        this.form = response.data
                        this.update = true
                        this.getNasabah()
                        $('#modalNasabah').modal('hide')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },
        }
    }

</script>
