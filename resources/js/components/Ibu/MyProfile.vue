<template>
    <div class="max-w-3xl mx-auto p-4">
        <div class="grid grid-cols-2 gap-4">
            <h1 class="text-2xl font-bold font-sans mb-6">PROFILE</h1>
            <div class="flex justify-end gap-x-3">
                <router-link to="/" class="text-blue-500"><img class="w-5 h-5 cursor-pointer"
                        :src="'storage/images/home.png'"></router-link>
            </div>
        </div>
        <div v-if="!mom" class="flex justify-center item-center">
            <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
                <div class="text-center">
                    <p class="text-base font-semibold text-indigo-600">404</p>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Data not found</h1>
                    <p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn’t find the data you’re looking
                        for.</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/"
                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go
                            back home</a>
                        <a href="/" class="text-sm font-semibold text-gray-900">Contact support <span
                                aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
            </main>
        </div>
        <div v-else>
            <div class="my-2">
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <h1 class="text-xl font-mono font-bold">Identitas Ibu</h1>
                        <div class="flex justify-end gap-x-3">
                            <img class="w-5 h-5 cursor-pointer" @click="editIbu" :src="'storage/images/edit.png'">
                        </div>
                    </div>
                </div>
                <!-- Daftar Pertanyaan -->
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nama Ibu</p>
                    <p class="text-justify font-medium italic">{{ mom.name || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Induk Kependudukan</p>
                    <p class="text-justify font-medium italic">{{ mom.nik || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tempat Lahir</p>
                    <p class="text-justify font-medium italic">{{ mom.birth_place || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tanggal Lahir</p>
                    <p class="text-justify font-medium italic">{{ mom.date_of_birth || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Whatsapp</p>
                    <p class="text-justify font-medium italic">{{ mom.phone_number || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Jaminan Kesehatan Nasional</p>
                    <p class="text-justify font-medium italic">{{ mom.no_jkn || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tinggi</p>
                    <p class="text-justify font-medium italic">{{ mom.height || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Golongan Darah</p>
                    <p class="text-justify font-medium italic">{{ mom.blood_type.blood_type_name || 'N/A' }} ( {{
                        mom.blood_type.reshus || 'N/A'
                        }}
                        )</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Alamat</p>
                    <p class="text-justify font-medium italic">{{ mom.address || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Kecamatan</p>
                    <p class="text-justify font-medium italic">{{ mom.kecamatan.kecamatan_name || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Agama</p>
                    <p class="text-justify font-medium italic">{{ mom.religion.religion_name || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Pendidikan</p>
                    <p class="text-justify font-medium italic">{{ mom.education.education_name || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Pekerjaan</p>
                    <p class="text-justify font-medium italic">{{ mom.job.job_name || 'N/A' }}</p>
                </div>
            </div>
            <div v-for="(dad, index) in mom.father" :key="index" class="my-2">
                <div class="my-2">
                    <div class="mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <h1 class="text-2xl font-bold">Identitas Ayah ke - {{ index + 1 }}</h1>
                            <div class="flex justify-end gap-x-3">
                                <img class="w-6 h-6" @click="addAyah" :src="'storage/images/add.png'">
                                <img class="w-6 h-6" @click="editAyah(dad.id)" :src="'storage/images/edit.png'">
                            </div>
                        </div>
                    </div>
                    <!-- Daftar Pertanyaan -->
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Nama Ayah</p>
                        <p class="text-justify font-medium italic">{{ dad.name || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Nomor Induk Kependudukan</p>
                        <p class="text-justify font-medium italic">{{ dad.nik || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Tempat Lahir</p>
                        <p class="text-justify font-medium italic">{{ dad.birth_place || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Tanggal Lahir</p>
                        <p class="text-justify font-medium italic">{{ dad.date_of_birth || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Nomor Whatsapp</p>
                        <p class="text-justify font-medium italic">{{ dad.phone_number || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Nomor Jaminan Kesehatan Nasional</p>
                        <p class="text-justify font-medium italic">{{ dad.no_jkn || 'N/A'}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Golongan Darah</p>
                        <p class="text-justify font-medium italic">{{ dad.blood_type.blood_type_name || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Alamat</p>
                        <p class="text-justify font-medium italic">{{ dad.address || 'N/A'}}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Kecamatan</p>
                        <p class="text-justify font-medium italic">{{ dad.kecamatan.kecamatan_name || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Agama</p>
                        <p class="text-justify font-medium italic">{{ dad.religion.religion_name || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Pendidikan</p>
                        <p class="text-justify font-medium italic">{{ dad.education.education_name || 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg mb-4">
                        <p class="mb-2">Pekerjaan</p>
                        <p class="text-justify font-medium italic">{{ dad.job.job_name || 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div v-for="(child, index) in mom.children" :key="index" class="my-2">
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <h1 class="text-2xl font-bold">Identitas Anak ke - {{ child.child_of || 'N/A' }} </h1>
                        <div class="flex justify-end gap-x-3">
                            <img class="w-6 h-6" @click="addAnak" :src="'storage/images/add.png'">
                            <img class="w-6 h-6" @click="editAnak(child.id)" :src="'storage/images/edit.png'">
                        </div>
                    </div>
                </div>
                <!-- Daftar Pertanyaan -->
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Akte Kelahiran</p>
                    <p class="text-justify font-medium italic">{{ child.akte_no || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Jenis Kelamin</p>
                    <p class="text-justify font-medium italic">{{ child.gender || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tempat Lahir</p>
                    <p class="text-justify font-medium italic">{{ child.birth_place || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tanggal Lahir</p>
                    <p class="text-justify font-medium italic">{{ child.date_of_birth || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Golongan Darah</p>
                    <p class="text-justify font-medium italic">{{ child.blood_type.blood_type_name || 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
    name: 'MyProfile',
    data() {
        return {
            ibu: [],
            ayah: [],
            anak: []
        }
    },
    computed: {
        ...mapGetters(['mom', 'baseUrl']),
    },
    methods: {
        editIbu() {
            // console.log("ibu", this.ibu)
            this.$router.push(`/update-profile/mother/${this.mom.id}`);
        },
        editAyah(fatherId) {
            // console.log("ibu", this.ibu)
            this.$router.push(`/update-profile/father/${fatherId}`);
        },
        editAnak(childId) {
            // console.log("ibu", this.ibu)
            this.$router.push(`/update-profile/child/${childId}`);
        },

    }
}
</script>
