<template>
    <div class="max-w-3xl mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">PROFIL</h2>

        <div class="my-2">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Identitas Ibu</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-6 h-6" @click="gotoHome" :src="'storage/images/home.png'">
                        <img class="w-6 h-6" @click="editAnswer" :src="'storage/images/edit.png'">
                    </div>
                </div>
            </div>
            <!-- Daftar Pertanyaan -->
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nama Ibu</p>
                <p class="text-justify font-medium italic">{{ ibu.name }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Induk Kependudukan</p>
                <p class="text-justify font-medium italic">{{ ibu.nik }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tempat Lahir</p>
                <p class="text-justify font-medium italic">{{ ibu.birth_place }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tanggal Lahir</p>
                <p class="text-justify font-medium italic">{{ ibu.date_of_birth }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Whatsapp</p>
                <p class="text-justify font-medium italic">{{ ibu.phone_number }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Jaminan Kesehatan Nasional</p>
                <p class="text-justify font-medium italic">{{ ibu.no_jkn }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tinggi</p>
                <p class="text-justify font-medium italic">{{ ibu.height }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Golongan Darah</p>
                <!-- <p class="text-justify font-medium italic">{{ ibu.blood_type.blood_type_name }}</p> -->
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Alamat</p>
                <p class="text-justify font-medium italic">{{ ibu.address }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Kecamatan</p>
                <p class="text-justify font-medium italic">{{ ibu.kecamatan_name }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Agama</p>
                <p class="text-justify font-medium italic">{{ ibu.religion_name }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Pendidikan</p>
                <p class="text-justify font-medium italic">{{ ibu.education_name }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Pekerjaan</p>
                <p class="text-justify font-medium italic">{{ ibu.job_name }}</p>
            </div>
        </div>
        <div class="my-2">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Identitas Ayah</h1>
                    <div class="flex justify-end gap-x-3">
                        <img class="w-6 h-6" @click="addFather" :src="'storage/images/add.png'">
                        <img class="w-6 h-6" @click="editFather" :src="'storage/images/edit.png'">
                    </div>
                </div>
            </div>
            <!-- Daftar Pertanyaan -->
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nama Ayah</p>
                <p class="text-justify font-medium italic">{{ ayah.name }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Induk Kependudukan</p>
                <p class="text-justify font-medium italic">{{ ayah.nik }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tempat Lahir</p>
                <p class="text-justify font-medium italic">{{ ayah.birth_place }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tanggal Lahir</p>
                <p class="text-justify font-medium italic">{{ ayah.date_of_birth }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Whatsapp</p>
                <p class="text-justify font-medium italic">{{ ayah.phone_number }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Nomor Jaminan Kesehatan Nasional</p>
                <p class="text-justify font-medium italic">{{ ayah.no_jkn }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Tinggi</p>
                <p class="text-justify font-medium italic">{{ ayah.height }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Golongan Darah</p>
                <!-- <p class="text-justify font-medium italic">{{ ayah.blood_type.blood_type_name }}</p> -->
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Alamat</p>
                <p class="text-justify font-medium italic">{{ ayah.address }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Kecamatan</p>
                <!-- <p class="text-justify font-medium italic">{{ ayah.kecamatan_id.kecamatan_name }}</p> -->
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Agama</p>
                <!-- <p class="text-justify font-medium italic">{{ ayah.religion.religion_name }}</p> -->
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Pendidikan</p>
                <!-- <p class="text-justify font-medium italic">{{ ayah.education.education_name }}</p> -->
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Pekerjaan</p>
                <!-- <p class="text-justify font-medium italic">{{ ayah.job.job_name }}</p> -->
            </div>
        </div>
        <div v-for="(child, index) in mom.children" :key="index" class="my-2">
            <div class="mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <h1 class="text-2xl font-bold">Identitas Anak ke - {{ index + 1 }} </h1>
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
                <p class="mb-2">Tinggi Saat Lahir</p>
                <p class="text-justify font-medium italic">{{ child.height }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <p class="mb-2">Berat Saat Lahir</p>
                <p class="text-justify font-medium italic">{{ child.weigth }}</p>
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
            ayah: [{
                nik: '',
                name: '',
                birth_place: '',
                birth_date: '',
                gender: '',
                birth_weight: '',
                blood_type_id: '',
                no_jkn: '',
                height: '',
                address: '',
                kecamatan_id: '',
                religion_id: '',
                education_id: '',
                job_id: ''
            }],
            anak: [{
                akte_no: '',
                gender: '',
                birth_place: '',
                date_of_birth: '',
                gender: '',
                height: '',
                weigth: '',
            }]
        }
    },
    computed: {
        ...mapGetters(['mom', 'baseUrl']),
    },
    mounted() {
        this.fetchDataIbu()
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
        editChild(index) {
            // Open modal for editing anak
        },
        fetchDataIbu() {
            this.ibu = this.mom;
            console.log('url', `${this.baseUrl}/api/combo/kecamatan/${this.mom.kecamatan_id}`);
            axios.get(`${this.baseUrl}/api/combo/kecamatan/${this.mom.kecamatan_id}`)
                .then(res => res.data)
                .then(res => {
                    console.log("kecamatan ibu : ", res);
                    this.ibu.kecamatan_name = res.data.kecamatan_name;
                })
            // axios.get(`${this.baseUrl}/api/combo/religion/${this.mom.religion_id}`)
            //     .then(res => res.data)
            //     .then(res => {
            //         console.log("religion ibu : ", res);
            //         this.ibu.religion_name = res.data.religion_name;
            //     })
            // axios.get(`${this.baseUrl}/api/combo/education/${this.mom.education_id}`)
            //     .then(res => res.data)
            //     .then(res => {
            //         console.log("education ibu : ", res);
            //         this.ibu.education_name = res.data.education_name;
            //     })
            // axios.get(`${this.baseUrl}/api/combo/job/${this.mom.job_id}`)
            //     .then(res => res.data)
            //     .then(res => {
            //         console.log("job ibu : ", res);
            //         this.ibu.job_name = res.data.job_name;
            //     })
            // axios.get(`${this.baseUrl}/api/combo/blood_type/${this.mom.blood_type_id}`)
            //     .then(res => res.data)
            //     .then(res => {
            //         console.log("blood_type ibu : ", res);
            //         this.ibu.blood_type_name = res.data.blood_type_name;
            //     })
        },
        fetchDataAnak() {
            this.anak = this.mom.children;
        }
    }
}


// export default {
//     setup() {
//         const router = useRouter();



//         const questions = ref([
//             {
//                 text: 'Demam Lebih dari Dua Hari?',
//                 type: 'choice',
//                 answer: 'YA'
//             },
//             {
//                 text: 'Pusing/Sakit Kepala Berat?',
//                 type: 'choice',
//                 answer: 'YA'
//             },
//             {
//                 text: 'Sulit Tidur / Cemas Berlebih?',
//                 type: 'choice',
//                 answer: 'TIDAK'
//             },
//             {
//                 text: 'Keluhan/Gejala Lainnya',
//                 type: 'text',
//                 answer: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus malesuada ultrices. Quisque in lobortis justo. Morbi placerat eget erat eu maximus. Nullam in dapibus est. Fusce vel maximus tortor. Fusce a eros erat. Curabitur posuere tellus id nisl vulputate, ut tristique orci fringilla. Suspendisse a orci eget tellus tincidunt pulvinar. Morbi dignissim, arcu at elementum porttitor, nunc risus pulvinar erat, aliquet dictum risus nunc ut lorem. Cras id scelerisque dui, et pharetra quam. Integer placerat tincidunt leo non viverra. Donec consequat nibh venenatis, pellentesque arcu id, eleifend turpis. In hac habitasse platea dictumst. Nunc vel urna nec tellus fermentum congue. Curabitur laoreet vitae leo eget rutrum. Proin a posuere turpis.'
//             }
//         ]);

//         const editAnswer = () => {
//             router.push({
//                 name: 'weekly-monitoring-answer',
//                 params: {}
//             });
//         };

//         const gotoHome = () => {
//             router.push({
//                 name: 'home',
//                 params: {}
//             });
//         };

//         return {
//             questions,
//             editAnswer,
//             gotoHome
//         };
//     }
// }
</script>
