<template>
    <div>
        <div v-if="update" class="alert alert-info alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>
            <strong>Berhasil!</strong> Data pinjaman telah di update!
        </div>

        <div class="main-content-container container-fluid px-4">
            <!-- Page Header -->
            <div class="page-header row no-gutters py-4">
                <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                    <span class="text-uppercase page-subtitle">Overview</span>
                    <h3 class="page-title">Pinjaman</h3>
                </div>
            </div>
            <!-- Default Light Table -->

            <div class="row">
                <div class="col">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-sm btn-pill btn-outline-primary" data-toggle="modal"
                                    data-target="#pinjamanModal" @click="edit = true">
                                    <i class="material-icons mr-1">attach_money</i>Tambah</button>
                                <form action="pinjaman/report">
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
                            </div>
                        </div>
                        <div class="card-body p-0 pb-3 ">
                            <table class="table mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="border-1">Kode Transaksi</th>
                                        <th scope="col" class="border-1">Nama Nasabah</th>
                                        <th scope="col" class="border-1">Uang Yang Dipinjam</th>
                                        <th scope="col" class="border-1">Sudah Dibayar</th>
                                        <th scope="col" class="border-1">Sisa Pembayaran</th>
                                        <th scope="col" class="border-1">Durasi /Bulan</th>
                                        <th scope="col" class="border-1">Tanggal</th>
                                        <th scope="col" class="border-1">Pengelola</th>
                                        <th scope="col" class="border-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(pinjaman, index) in pinjamans" :key="pinjaman.id">

                                        <td>{{ pinjaman.kode_transaksi }}</td>
                                        <td>{{ pinjaman.user.name }}</td>
                                        <td>{{ formatPrice(pinjaman.jumlah) }}</td>
                                        <td>{{ formatPrice(pinjaman.sudah_bayar) }}</td>
                                        <td>{{ formatPrice(pinjaman.sisa_bayar) }}</td>
                                        <td>{{ pinjaman.durasi }}</td>
                                        <td>{{ pinjaman.tanggal }}</td>
                                        <td>{{ pinjaman.pengelola }}</td>
                                        <td>
                                            <a href="#" class="" v-on:click="editPinjaman(pinjaman.id)">
                                                <i class="material-icons mr-1">edit</i>
                                            </a>
                                            <a href="#" v-on:click="deletePinjaman(pinjaman.id, index, pinjaman.user.name)">
                                                <i class="material-icons" title="delete">delete</i>
                                            </a>

                                            <a :href="'pinjaman/'+pinjaman.id+'/edit'" >
                                                <i class="material-icons" title="bayar">local_atm</i>
                                            </a>

                                            <a :href="'pinjaman/'+pinjaman.id+'/struk'" >
                                                <i class="material-icons" title="struk">credit_card</i>
                                            </a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="float-right mr-2 mt-2">
                                <vue-pagination :data="pinjaman" v-on:pagination-change-page="getPinjaman" :limit="1"></vue-pagination>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="pinjamanModal" tabindex="-1" role="dialog" aria-labelledby="pinjamanModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form v-on:submit.prevent="edit ? saveForm() : updateForm()">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pinjamanModalLabel">{{ edit ? 'Tambah Pinjaman'
                                                : 'Edit Pinjaman' }}</h5>
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
                                                <label for="Jumlah">Jumlah Pinjaman</label>
                                                <input type="number" id="Jumlah" v-model="form.jumlah" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label for="Durasi">Durasi</label>
                                                <select id="Durasi" class="form-control" v-model="form.durasi">
                                                    <option v-for="durasi in options.durasi" :key="durasi.id" :value="durasi.value">
                                                        {{ durasi.name }}
                                                    </option>
                                                </select>
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
        name: 'pinjaman-list',
        data() {
            return {
                pinjamans: [],
                pinjaman: {},
                pencarian: '',
                edit: false,
                update: false,
                loading: true,

                options: {
                    selectUser: [],
                    durasi: [
                        { name: '6 Bulan', value: 6 },
                        { name: '12 Bulan', value: 12 },
                        { name: '24 Bulan', value: 24 },
                    ]
                },

                form: {
                    id: '',
                    user_id: '',
                    kode_transaksi: 'PJM',
                    jumlah: 0,
                    durasi: '',
                    tanggal: ''
                }
            }
        },

        mounted() {
            this.getPinjaman()
            this.getUser()
        },

        watch: {
            // whenever question changes, this function will run
            pencarian: function (q) {
                this.getPinjaman()
            },
        },

        methods: {
            getUser() {
                axios.get('api/pinjaman/create')
                    .then(function (response) {
                        this.options.selectUser = response.data
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        alert("Could not load user");
                    }.bind(this));
            },

            getPinjaman(page = 1) {
                if (typeof page === 'undefined') {
                    page = 1;
                }

                axios.get('api/pinjaman?q=' + this.pencarian + '&page=' + page)
                    .then(function (response) {
                        this.pinjamans = response.data.data;
                        this.pinjaman = response.data;
                        this.loading = false;
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.loading = false;
                        alert("Could not load pinjaman");
                    }.bind(this));
            },

            saveForm() {
                axios.post('pinjaman', this.form)
                    .then(function (response) {
                        alert('Pinjaman Berhasil')
                        $('#pinjamanModal').modal('hide')
                        this.getPinjaman()
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            editPinjaman(id) {
                axios.get('api/pinjaman/' + id)
                    .then(function (response) {
                        this.edit = false
                        this.update = false
                        this.form = response.data
                        $('#pinjamanModal').modal('show')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            deletePinjaman(id, kode_transaksi) {
                if (confirm("Yakin Ingin Menghapus Data Pinjaman " + kode_transaksi + " ?")) {
                    axios.delete('api/pinjaman/' + id)
                        .then(function (response) {
                            alert("Berhasil Menghapus Kode Transaksi " + kode_transaksi)
                            this.getPinjaman()
                        }.bind(this))
                        .catch(function (error) {
                            console.log(error)
                        }.bind(this));
                }
            },

            updateForm() {
                axios.patch('pinjaman/' + this.form.id, this.form)
                    .then(function (response) {
                        this.form = response.data
                        this.update = true
                        this.getPinjaman()
                        $('#pinjamanModal').modal('hide')
                        console.log(response.data)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.errors = error.response.data.errors
                    }.bind(this));
            },

            formatPrice(value) {
                let val = (value/1).toFixed(0).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }

        }
    }

</script>
