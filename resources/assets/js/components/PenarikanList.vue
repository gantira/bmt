<template>
    <div>
        <div v-if="update" class="alert alert-info alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>
            <strong>Berhasil!</strong> Data penarikan telah di update!
        </div>

        <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
                <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                    <span class="text-uppercase page-subtitle">Overview</span>
                    <h3 class="page-title">Penarikan</h3>
                </div>
            </div>
            <!-- Default Light Table -->

            <div class="row">
                <div class="col">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <h6 class="m-0 d-flex justify-content-between">
                                <button type="button" class="btn btn-sm btn-pill btn-outline-primary" data-toggle="modal"
                                    data-target="#penarikanModal" @click="edit = true">
                                    <i class="material-icons mr-1">attach_money</i>Tambah</button>
                                <form action="penarikan/report">
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
                                    <tr v-for="penarikan in penarikans" :key="penarikan.id">
                                        <td>{{ penarikan.kode_transaksi }}</td>
                                        <td>{{ penarikan.tanggal }}</td>
                                        <td>{{ penarikan.user.name }}</td>
                                        <td>{{ formatPrice(penarikan.kredit) }}</td>
                                        <td>{{ formatPrice(penarikan.debit) }}</td>
                                        <td>{{ formatPrice(penarikan.saldo) }}</td>
                                        <td>{{ penarikan.pengelola }}</td>
                                        <td>
                                            <a href="#" class="" v-on:click="editSimpanan(penarikan.id)">
                                                <i class="material-icons mr-1">edit</i>
                                            </a>
                                            <a href="#" class="" v-on:click="deleteSimpanan(penarikan.id, penarikan.kode_transaksi)">
                                                <i class="material-icons mr-1">delete</i>
                                            </a>
                                            <a :href="'penarikan/'+penarikan.id+'/struk'" class="" title="struk">
                                                <i class="material-icons">credit_card</i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="float-right mr-2 mt-2">
                                <vue-pagination :data="penarikan" v-on:pagination-change-page="getSimpanan" :limit="1"></vue-pagination>
                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="penarikanModal" tabindex="-1" role="dialog" aria-labelledby="penarikanModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form v-on:submit.prevent="edit ? saveForm() : updateForm()">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="penarikanModalLabel">{{ edit ? 'Tambah Simpanan'
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
                                                <label for="Jumlah">Jumlah Penarikan</label>
                                                <input type="number" id="Jumlah" v-model="form.kredit" class="form-control">
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
        name: 'penarikan-list',
        data() {
            return {
                penarikans: [],
                penarikan: {},
                pencarian: '',
                edit: false,
                update: false,

                options: {
                    selectUser: []
                },

                form: {
                    id: '',
                    user_id: '',
                    jenis: 'PNK',
                    kode_transaksi: 'PNK',
                    kredit: 0,
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
                axios.get('api/penarikan/create')
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

                axios.get('api/penarikan?q=' + this.pencarian + '&page=' + page)
                    .then(function (response) {
                        this.penarikans = response.data.data;
                        this.penarikan = response.data;
                        this.loading = false;
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.loading = false;
                        alert("Could not load penarikan");
                    }.bind(this));
            },

            saveForm() {
                axios.post('penarikan', this.form)
                    .then(function (response) {
                        alert('Simpanan Berhasil')
                        $('#penarikanModal').modal('hide')
                        this.getSimpanan()
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                        alert(error.response.data.message)
                    }.bind(this));
            },

            editSimpanan(id) {
                axios.get('api/penarikan/' + id)
                    .then(function (response) {
                        this.edit = false
                        this.update = false
                        this.form = response.data
                        $('#penarikanModal').modal('show')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            deleteSimpanan(id, kode_transaksi) {
                if (confirm("Yakin Ingin Menghapus Data Simpanan " + kode_transaksi + " ?")) {
                    axios.delete('api/penarikan/' + id)
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
                axios.patch('penarikan/' + this.form.id, this.form)
                    .then(function (response) {
                        this.form = response.data
                        this.update = true
                        this.getSimpanan()
                        $('#penarikanModal').modal('hide')
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
