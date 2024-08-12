<template>
    <div class="max-w-3xl mx-auto p-4">
        <h1 class="text-2xl font-bold font-sans mb-6">PROFILE</h1>

        <div class="my-2">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-xl font-mono font-bold">Identitas Ibu</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-5 h-5 cursor-pointer" @click="redBack" :src="'storage/images/home.png'">
                        <img class="w-5 h-5 cursor-pointer" @click="editIbu" :src="'storage/images/edit.png'">
                    </div>
                </div>
            </div>
            <!-- Daftar Pertanyaan -->
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nama Ibu</p>
                <p class="text-justify font-medium italic">{{ mom.name }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Induk Kependudukan</p>
                <p class="text-justify font-medium italic">{{ mom.nik }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tempat Lahir</p>
                <p class="text-justify font-medium italic">{{ mom.birth_place }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tanggal Lahir</p>
                <p class="text-justify font-medium italic">{{ mom.date_of_birth }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Whatsapp</p>
                <p class="text-justify font-medium italic">{{ mom.phone_number }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Jaminan Kesehatan Nasional</p>
                <p class="text-justify font-medium italic">{{ mom.no_jkn }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tinggi</p>
                <p class="text-justify font-medium italic">{{ mom.height }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Golongan Darah</p>
                <p class="text-justify font-medium italic">{{ mom.blood_type.blood_type_name }} ( {{
                    mom.blood_type.reshus || 'N/A'
                }}
                    )</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Alamat</p>
                <p class="text-justify font-medium italic">{{ mom.address }}</p>
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
                            <img class="w-6 h-6" @click="addFather" :src="'storage/images/add.png'">
                            <img class="w-6 h-6" @click="editFather" :src="'storage/images/edit.png'">
                        </div>
                    </div>
                </div>
                <!-- Daftar Pertanyaan -->
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nama Ayah</p>
                    <p class="text-justify font-medium italic">{{ dad.name }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Induk Kependudukan</p>
                    <p class="text-justify font-medium italic">{{ dad.nik }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tempat Lahir</p>
                    <p class="text-justify font-medium italic">{{ dad.birth_place }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Tanggal Lahir</p>
                    <p class="text-justify font-medium italic">{{ dad.date_of_birth }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Whatsapp</p>
                    <p class="text-justify font-medium italic">{{ dad.phone_number }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Nomor Jaminan Kesehatan Nasional</p>
                    <p class="text-justify font-medium italic">{{ dad.no_jkn }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Golongan Darah</p>
                    <p class="text-justify font-medium italic">{{ dad.blood_type.blood_type_name || 'N/A' }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="mb-2">Alamat</p>
                    <p class="text-justify font-medium italic">{{ dad.address }}</p>
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
                        <img class="w-6 h-6" @click="addChild" :src="'storage/images/add.png'">
                        <img class="w-6 h-6" @click="editChild" :src="'storage/images/edit.png'">
                    </div>
                </div>
            </div>
            <!-- Daftar Pertanyaan -->
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Akte Kelahiran</p>
                <p class="text-justify font-medium italic">{{ child.akte_no }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Jenis Kelamin</p>
                <p class="text-justify font-medium italic">{{ child.gender }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tempat Lahir</p>
                <p class="text-justify font-medium italic">{{ child.birth_place }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tanggal Lahir</p>
                <p class="text-justify font-medium italic">{{ child.date_of_birth }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Golongan Darah</p>
                <!-- <p class="text-justify font-medium italic">{{ child.blood_type.blood_type_name || 'N/A' }}</p> -->
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

        addChild() {
            this.anak.push({
                akte_no: '',
                gender: '',
                birth_place: '',
                date_of_birth: '',
                gender: '',
                height: '',
                weigth: '',
            });
        },
        editIbu() {
            // console.log("ibu", this.ibu)
            this.$router.push(`/update-profile/mother/${this.ibu.id}`);
        },

        redBack() {
            this.$router.go(-1);
        }
    }
}
</script>
