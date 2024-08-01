<template>
<div class="flex flex-col h-screen bg-gray-100 p-6">
    <user-card />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
    <!-- Profile Card -->
    <ProfileCard
        v-for="card in cards"
        :key="card.title"
        :title="card.title"
        :description="card.description"
        :link="card.link"
        :img="'/storage/images/janin.png'"
    />

    <!-- Chart Section -->
    <!-- <div class="col-span-1 md:col-span-2 lg:col-span-3">
        <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-xl font-semibold mb-4">Grafik Evaluasi Kehamilan</h2>
        <LineChart :data="chartData" />
        </div>
    </div> -->
    </div>
</div>
</template>

<script>
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, LineElement, CategoryScale, LinearScale } from 'chart.js';
import ProfileCard from './utils/ProfileCard.vue';
import toastr from 'toastr';
import UserCard from './UserCard.vue';
ChartJS.register(LineElement, CategoryScale, LinearScale);

export default {
components: {
    ProfileCard,
    LineChart: Line,
    UserCard
},
data() {
    return {
    user: {},
    mother: [],
    currentWeek: 0,
    weeks: [],
    cards: [
        { title: 'Info Janin Secara Umum', description: 'Tinggi : xxx cm Berat : xxx cm Ukuran : xxx Ciri-ciri : xxx', link: '#' },
        { title: 'Diary Ibu', description: 'Pemantauan mingguan, perawatan sehari-hari, serta keluhan yang dirasakan ibu dapat diisi secara mandiri dalam menu ini.', link: '#' },
        { title: 'Catatan Kesehatan Ibu', description: 'Hasil skrining preeklampsia dan hasil pemeriksaan kesehatan ibu, serta saran hingga tanggapan tenaga kesehatan terkait keluhan dapat dilihat dalam menu ini.', link: '#' },
        { title: 'Grafik Evaluasi Kehamilan', description: 'Grafik peningkatan berat badan dan grafik evaluasi kehamilan dapat dipantau dalam menu ini.', link: '#' },
        { title: 'Information', description: 'Informasi seputar kehamilan, pola makan dan minum ibu, aktivitas fisik dan latihan fisik, serta informasi relevan lainnya dapat dibaca pada menu ini.', link: '#' },
        { title: 'Riwayat Persalinan', description: 'Informasi seputar persalinan, kondisi bayi saat lahir, hingga asuhan bayi baru lahir (IMD dalam 1 jam pertama kelahiran) bisa dapat dilihat dalam menu ini.', link: '#' },
    ],
    chartData: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
        datasets: [
        {
            label: 'Weight Gain (kg)',
            data: [1, 2, 2.5, 3, 4, 5],
            borderColor: '#42A5F5',
            backgroundColor: 'rgba(66, 165, 245, 0.2)',
            fill: true
        },
        {
            label: 'Pregnancy Progress (%)',
            data: [10, 20, 30, 50, 70, 90],
            borderColor: '#FF5722',
            backgroundColor: 'rgba(255, 87, 34, 0.2)',
            fill: true
        }
        ]
    }
    };
},
methods: {
    fetchUserAuth() {

    axios.get('/user')
        .then(response => response.data)
        .then(response => {
        this.user = response.user;
            console.log('fetching user : ', response.user);
        })
        .catch(error => {
            console.error(error);
            toastr.error(`fetching user ERROR : ${error}`)
        });
    },
    fetchMother() {
    const user_id = this.user.id;
    axios.get(`/api/get_mother/${user_id}`)
        .then(response => response.data)
        .then(response => {
        console.log('fetching mother : ', response.data);
        })
    },
    fetchWeekUser() {
    const mother_id = this.mother.id
    axios.get(`/api/get_week_user/${mother_id}`)
        .then(response => response.data)
        .then(response => {
        console.log('fetching week : ', response);
        })
        .catch(error => {
        console.error(error);
        toastr.error(`fetching week ERROR : ${error}`)
        });
    }
},
mounted() {
    
}
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
