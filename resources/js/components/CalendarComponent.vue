<template>
    <div>
      <div id="calendar"></div>
    </div>
  </template>

  <script setup>
  import { onMounted, nextTick } from 'vue';
  import { Calendar } from '@fullcalendar/core';
  import dayGridPlugin from '@fullcalendar/daygrid';
  import googleCalendarPlugin from '@fullcalendar/google-calendar';

  onMounted(() => {
    nextTick(() => {
      const calendarEl = document.getElementById('calendar');
      if (!calendarEl) {
        console.error('calendar element not found');
        return;
      }

      const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, googleCalendarPlugin],
        initialView: 'dayGridMonth',
        timeZone: 'Asia/Tokyo',
        googleCalendarApiKey: 'AIzaSyDscaEr0w7I4KmkHi12xjS51wu2Dpj5BwY',
        eventSources: [
          {
            url: '/api/events' + window.location.search,
            method: 'GET',
            color: '#3788d8',
            failure: () => {
              alert('Laravelイベント取得失敗');
            },
          },
          {
            googleCalendarId: 'ja.japanese#holiday@group.v.calendar.google.com',
            color: '#ff9f89',
          },
        ],
      });

      calendar.render();
    });
  });
  </script>

  <style scoped>
  #calendar {
    max-width: 900px;
    margin: 40px auto;
    min-height: 600px;
  }
  </style>
