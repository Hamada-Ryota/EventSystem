<template>
    <div id="calendar"></div>
  </template>

  <script setup>
  import { onMounted, nextTick } from 'vue';
  import { Calendar } from '@fullcalendar/core';
  import dayGridPlugin from '@fullcalendar/daygrid';
  import interactionPlugin from '@fullcalendar/interaction';
  import googleCalendarPlugin from '@fullcalendar/google-calendar';

  onMounted(() => {
    nextTick(() => {
      const calendarEl = document.getElementById('calendar');

      const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin, googleCalendarPlugin],
        initialView: 'dayGridMonth',

        // イベントソース
        eventSources: [
          {
            url: '/api/events', // Laravelのイベント取得
            color: '#3788d8',
          },
          {
            googleCalendarId: 'ja.japanese#holiday@group.v.calendar.google.com',
            color: '#ff9f89',
          },
        ],

        googleCalendarApiKey: 'AIzaSyDscaEr0w7I4KmkHi12xjS51wu2Dpj5BwY',

        eventClick(info) {
          if (info.event.url) {
            window.open(info.event.url, '_blank');
            info.jsEvent.preventDefault();
          }
        },
      });

      calendar.render(); // ← DOM描画後に確実に実行！
    });
  });
  </script>

  <style scoped>
  #calendar {
    max-width: 900px;
    margin: 40px auto;
  }
  </style>
