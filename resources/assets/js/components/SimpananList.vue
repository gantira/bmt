<template>
    <div>
        <div v-if="update" class="alert alert-info alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>
            <strong>Berhasil!</strong> Data simpanan telah di update!
        </div>

        <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
                <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                    <span class="text-uppercase page-subtitle">Overview</span>
                    <h3 class="page-title">Simpanan</h3>
                </div>
            </div>
            <!-- Default Light Table -->

            <div class="row">
                <div class="col">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <h6 class="m-0 d-flex justify-content-between">
                                <button type="button" class="btn btn-sm btn-pill btn-outline-primary" data-toggle="modal"
                                    data-target="#simpananModal" @click="edit = true">
                                    <i class="material-icons mr-1">attach_money</i>Tambah</button>
                                <form action="simpanan/report">
                                    <div class="form-inline">
                                        <label for="tgl_awal">Report</label>
                                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control"> To
                                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                                        <button class="btn btn-sm btn-primary ml-1"><i class="material-icons">print</i></button>
                                    </div>
                                </form>
                                <div>
                                    <input type="text" v-model="pencarian" class="form-control" placeholder="Pencarian">
                                </div>
                            </h6>
                        </div>
                        <div class="card-body p-0 pb-3 text-center">
                            <table class="table mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="border-0">Kode Transaksi</th>
                                        <th scope="col" class="border-0">Tanggal</th>
                                        <th scope="col" class="border-0">Nasabah</th>
                                        <th scope="col" class="border-0">Debit</th>
                                        <th scope="col" class="border-0">Kredit</th>
                                        <th scope="col" class="border-0">Saldo</th>
                                        <th scope="col" class="border-0">Pengelola</th>
                                        <th scope="col" class="border-0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="simpanan in simpanans" :key="simpanan.id">
                                        <td>{{ simpanan.kode_transaksi }}</td>
                                        <td>{{ simpanan.tanggal }}</td>
                                        <td>{{ simpanan.user.name }}</td>
                                        <td>{{ formatPrice(simpanan.kredit) }}</td>
                                        <td>{{ formatPrice(simpanan.debit) }}</td>
                                        <td>{{ formatPrice(simpanan.saldo) }}</td>
                                        <td>{{ simpanan.pengelola }}</td>
                                        <td>
                                            <a href="#" class="" v-on:click="editSimpanan(simpanan.id)">
                                                <i class="material-icons mr-1">edit</i>
                                            </a>
                                            <a href="#" class="" v-on:click="deleteSimpanan(simpanan.id, simpanan.kode_transaksi)">
                                                <i class="material-icons">delete</i>
                                            </a>
                                            <a :href="'simpanan/'+simpanan.id+'/struk'" class="" title="struk">
                                                <i class="material-icons">credit_card</i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="float-right mr-2 mt-2">
                                <vue-pagination :data="simpanan" v-on:pagination-change-page="getSimpanan" :limit="1"></vue-pagination>
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="simpananModal" tabindex="-1" role="dialog" aria-labelledby="simpananModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form v-on:submit.prevent="edit ? saveForm() : updateForm()">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="simpananModalLabel">{{ edit ? 'Tambah Simpanan'
                                                : 'Edit Simpanan' }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="Pilih Nasabah">Pilih Nasabah</label>
                                                <select id="Pilih Nasabah" class="form-control" v-model="form.user_id">
                                                    <option v-for="user in options.selectUser" :key="user.id" :value="user.id">{{
                                                        user.name + ' - ' + user.no_anggota }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="Jenis Simpanan">Jenis Simpanan</label>
                                                <select id="Jenis Simpanan" class="form-control" v-model="form.jenis"
                                                    @change="form.kode_transaksi = form.jenis ">
                                                    <option v-for="simpanan in options.selectSimpanan" :key="simpanan.id"
                                                        :value="simpanan.value">{{ simpanan.name }}</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="Jumlah">Jumlah</label>
                                                <input type="number" id="Jumlah" v-model="form.debit" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="Tanggal">Tanggal</label>
                                                <input type="date" id="Tanggal" v-model="form.tanggal" class="form-control">
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
        name: 'simpanan-list',
        data() {
            return {
                simpanans: [],
                simpanan: {},
                pencarian: '',
                edit: false,
                update: false,

                options: {
                    selectSimpanan: [{
                            name: 'Simpanan Pokok',
                            value: 'SP'
                        },
                        {
                            name: 'Simpanan Wajib',
                            value: 'SW'
                        },
                        {
                            name: 'Simpanan Sukarela',
                            value: 'SS'
                        },
                    ],
                    selectUser: []
                },

                form: {
                    id: '',
                    user_id: '',
                    jenis: '',
                    kode_transaksi: '',
                    debit: 0,
                    tanggal: ''
                }
            }
        },

        mounted() {
            this.getSimpanan()
            this.getUser()
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
                this.getSimpanan()
            },

        },

        methods: {
            getUser() {
                axios.get('api/simpanan/create')
                    .then(function (response) {
                        this.options.selectUser = response.data
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        alert("Could not load user");
                    }.bind(this));
            },

            getSimpanan(page = 1) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('api/simpanan?q=' + this.pencarian + '&page=' + page)
                    .then(function (response) {
                        this.simpanans = response.data.data;
                        this.simpanan = response.data;
                        this.loading = false;
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.loading = false;
                        alert("Could not load simpanan");
                    }.bind(this));
            },

            saveForm() {
                axios.post('simpanan', this.form)
                    .then(function (response) {
                        alert('Simpanan Berhasil')
                        $('#simpananModal').modal('hide')
                        this.getSimpanan()
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            editSimpanan(id) {
                axios.get('api/simpanan/' + id)
                    .then(function (response) {
                        this.edit = false
                        this.update = false
                        this.form = response.data
                        $('#simpananModal').modal('show')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            deleteSimpanan(id, kode_transaksi) {
                if (confirm("Yakin Ingin Menghapus Data Simpanan " + kode_transaksi + " ?")) {
                    axios.delete('api/simpanan/' + id)
                        .then(function (response) {
                            alert("Berhasil Menghapus Kode Transaksi " + kode_transaksi)
                            this.getSimpanan()
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error)
                        }.bind(this));
                }
            },

            updateForm() {
                axios.patch('simpanan/' + this.form.id, this.form)
                    .then(function (response) {
                        this.form = response.data
                        this.update = true
                        this.getSimpanan()
                        $('#simpananModal').modal('hide')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }

        }
    }

</script>
