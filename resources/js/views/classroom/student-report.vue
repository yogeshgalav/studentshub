<template>
  <div>
    <doughnut-graph :graph-data="pieChartData" />
    <multiBar-graph :graph-data="[{ id: 2, count: 3 }]" />
    <linear-graph :graph-data="[{ id: 2, count: 3 }]" />
  </div>
</template>

<script>
import DoughnutGraph from "../../components/graphs/DoughnutGraph";
import MultiBarGraph from "../../components/graphs/MultiBarGraph";
import LinearGraph from "../../components/graphs/LinearGraph";

export default {
  components: {
    DoughnutGraph,
    MultiBarGraph,
    LinearGraph,
  },
  data() {
    return {
      showLoader: true,
      assignments_attemps: null,
    };
  },
  computed: {
    pieChartData() {
      console.log(this.assignments_attemps);
      return this.assignments_attemps;
    },
  },
  mounted() {
    let url =
      "/api/classroom/" +
      this.$route.params.classroomId +
      "/get-student-report-data";
    if (this.$route.name === "ClassroomStudentPanel") {
      url = url + "/" + this.$router.currentRoute.params.userId;
    }
    this.axios.get(url).then((resp) => {
      this.assignments_attemps = resp.data.success.assignments_attemps;
      //   this.assignments_attemps = [];
      //   console.log(this.assignments_attemps);
      //   pieChartData.map((data) => {
      //     this.assignments_attemps.push(data);
      //   });
      //   console.log(this.assignments_attemps);
      //   //   this.getDailyReports(pieChartData);
      this.showLoader = false;
    });
  },
  methods: {
    getDailyReports(pieChartData) {
      //   console.log(pieChartData);
      pieChartData.map((data) => {
        this.assignments_attemps = JSON.parse(JSON.stringify(data));
        console.log(this.assignments_attemps);
      });
    },
  },
};
</script>

