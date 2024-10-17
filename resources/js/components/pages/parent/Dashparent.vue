<template>
    <div>
        <div class="wrapper">
            <Header />
            <MenuParent />
            <div class="content-wrapper">
                <div class="container-full">
                    <section class="content">
                        <div class="row">
                            <div class="col-xl-8 col-12">
                                <div class="box bg-primary-light">
                                    <div class="box-body d-flex px-0">
                                        <div
                                            class="flex-grow-1 p-30 flex-grow-1 bg-img dask-bg bg-none-md"
                                            style="background-position: right bottom; background-size: auto 100%; background-image: url(https://www.multipurposethemes.com/admin/eduadmin-template/images/svg-icon/color-svg/custom-1.svg)"
                                        >
                                            <div class="row">
                                                <div class="col-12 col-xl-7">
                                                    <h4>
                                                        Bienvenu(e)  parent
                                                        <strong>{{
                                                            users.nom
                                                        }}  {{ users.prenom }}
                                                        </strong>

                                                    </h4>


                                                </div>
                                                <div
                                                    class="col-12 col-xl-5"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                         <div
                                        class="col-md-4 "
                                        v-for="(data, i) in InfosParent"
                                        :key="i"
                                    >
                                        <a href="#" class="box pull-up" >

                                                <img
                                                            style="margin:-10px auto auto;width: 100px;border-radius: 50%;"
                                                            class="card-img-top img-responsive"
                                                            :src="
                                                                `/Photos/Logos/${data.user.photo}`
                                                            "
                                                            alt="Card image cap"
                                                        />

                                                <div class="table-responsive" @click="SadeDataEnfant(data,i)">
                                                    <table
                                                        class="table simple mb-0 mt-8"
                                                    >
                                                        <tbody>
                                                            <br />
                                                            <tr>
                                                                <td
                                                                    class="font-weight-700 text-center"
                                                                >
                                                                    {{
                                                                        data.nom
                                                                    }}
                                                                    {{
                                                                        data.prenom
                                                                    }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    class="font-weight-700 text-center"
                                                                >
                                                                    {{
                                                                        data
                                                                            .classe
                                                                            .libelleClasse
                                                                    }}
                                                                </td>
                                                            </tr>




                                                            <tr>

                                                                <button
                                                                    style="width: 100%;"
                                                                    class="btn btn-primary"
                                                                >
                                                                  <router-link to="DashParentGeneralites">
                                                                    Les détails
                                                                 </router-link>
                                                                </button>
                                                            </tr>


                                                        </tbody>
                                                    </table>
                                                </div>

                                        </a>
                                    </div>


                                </div>
                            </div>
                            <div class="col-xl-4 col-12">
                                <div class="row">
                                    <a href="#" class="box pull-up">
                                        <div class="box-body">
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <div
                                                    class="icon bg-primary-light rounded-circle w-60 h-60 text-center l-h-80"
                                                >
                                                    <span
                                                        class="font-size-30 icon-Bulb1"
                                                        >{{InfosParent.length}}</span
                                                    >
                                                </div>
                                                <div class="ml-15">
                                                    <h5 class="mb-0">
                                                        Enfant<span v-if="InfosParent.length>1">s</span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="box">
                                        <div class="box-body"> <br>
                                            <div
                                                class="box no-shadow mb-0 px-10"
                                            >
                                                <div
                                                    class="box-header no-border"
                                                >
                                                    <h4 class="box-title">
                                                        Lessons
                                                    </h4>
                                                    <div
                                                        class="box-controls pull-right d-md-flex d-none"
                                                    >
                                                        <a href="#">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-10">
                                                <div class="box mb-15">
                                                    <div class="box-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between"
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <div
                                                                    class="mr-15 bg-warning h-50 w-50 l-h-60 rounded text-center"
                                                                >
                                                                    <span
                                                                        class="icon-Book-open font-size-24"
                                                                        ><span
                                                                            class="path1"
                                                                        ></span
                                                                        ><span
                                                                            class="path2"
                                                                        ></span
                                                                    ></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column font-weight-500"
                                                                >
                                                                    <a
                                                                        href="#"
                                                                        class="text-dark hover-primary mb-1 font-size-16"
                                                                        >Informatic
                                                                        Course</a
                                                                    >
                                                                    <span
                                                                        class="text-fade"
                                                                        >Johen
                                                                        Doe, 19
                                                                        April</span
                                                                    >
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                <span
                                                                    class="icon-Arrow-right font-size-24"
                                                                    ><span
                                                                        class="path1"
                                                                    ></span
                                                                    ><span
                                                                        class="path2"
                                                                    ></span
                                                                ></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box mb-15">
                                                    <div class="box-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between"
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <div
                                                                    class="mr-15 bg-primary h-50 w-50 l-h-60 rounded text-center"
                                                                >
                                                                    <span
                                                                        class="icon-Mail font-size-24"
                                                                    ></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column font-weight-500"
                                                                >
                                                                    <a
                                                                        href="#"
                                                                        class="text-dark hover-primary mb-1 font-size-16"
                                                                        >Live
                                                                        Drawing</a
                                                                    >
                                                                    <span
                                                                        class="text-fade"
                                                                        >Micak
                                                                        Doe, 12
                                                                        June</span
                                                                    >
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                <span
                                                                    class="icon-Arrow-right font-size-24"
                                                                    ><span
                                                                        class="path1"
                                                                    ></span
                                                                    ><span
                                                                        class="path2"
                                                                    ></span
                                                                ></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box mb-0">
                                                    <div class="box-body">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between"
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <div
                                                                    class="mr-15 bg-danger h-50 w-50 l-h-60 rounded text-center"
                                                                >
                                                                    <span
                                                                        class="icon-Book-open font-size-24"
                                                                        ><span
                                                                            class="path1"
                                                                        ></span
                                                                        ><span
                                                                            class="path2"
                                                                        ></span
                                                                    ></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex flex-column font-weight-500"
                                                                >
                                                                    <a
                                                                        href="#"
                                                                        class="text-dark hover-primary mb-1 font-size-16"
                                                                        >Contemporary
                                                                        Art</a
                                                                    >
                                                                    <span
                                                                        class="text-fade"
                                                                        >Potar
                                                                        doe, 27
                                                                        July</span
                                                                    >
                                                                </div>
                                                            </div>
                                                            <a href="#">
                                                                <span
                                                                    class="icon-Arrow-right font-size-24"
                                                                    ><span
                                                                        class="path1"
                                                                    ></span
                                                                    ><span
                                                                        class="path2"
                                                                    ></span
                                                                ></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="box no-shadow mb-0">
                                                <div class="box-body px-0 pt-0">
                                                    <div
                                                        id="calendar"
                                                        class="dask evt-cal min-h-400 fc fc-unthemed fc-ltr"
                                                    >
                                                        <div
                                                            class="fc-toolbar fc-header-toolbar"
                                                        >
                                                            <div
                                                                class="fc-left"
                                                            >
                                                                <div
                                                                    class="btn-group"
                                                                >
                                                                    <button
                                                                        type="button"
                                                                        class="fc-prev-button btn btn-primary fc-corner-left"
                                                                        aria-label="prev"
                                                                    >
                                                                        <span
                                                                            class="fc-icon fc-icon-left-single-arrow"
                                                                        ></span></button
                                                                    ><button
                                                                        type="button"
                                                                        class="fc-next-button btn btn-primary fc-corner-right"
                                                                        aria-label="next"
                                                                    >
                                                                        <span
                                                                            class="fc-icon fc-icon-right-single-arrow"
                                                                        ></span>
                                                                    </button>
                                                                </div>
                                                                <button
                                                                    type="button"
                                                                    class="fc-today-button btn btn-primary fc-corner-left fc-corner-right btn-primary-disabled"
                                                                    disabled=""
                                                                >
                                                                    today
                                                                </button>
                                                            </div>
                                                            <div
                                                                class="fc-right"
                                                            >
                                                                <div
                                                                    class="btn-group"
                                                                >
                                                                    <button
                                                                        type="button"
                                                                        class="fc-month-button btn btn-primary fc-corner-left active"
                                                                    >
                                                                        month</button
                                                                    ><button
                                                                        type="button"
                                                                        class="fc-agendaWeek-button btn btn-primary"
                                                                    >
                                                                        week</button
                                                                    ><button
                                                                        type="button"
                                                                        class="fc-agendaDay-button btn btn-primary fc-corner-right"
                                                                    >
                                                                        day
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="fc-center"
                                                            >
                                                                <h2>
                                                                    November
                                                                    2021
                                                                </h2>
                                                            </div>
                                                            <div
                                                                class="fc-clear"
                                                            ></div>
                                                        </div>
                                                        <div
                                                            class="fc-view-container"
                                                            style=""
                                                        >
                                                            <div
                                                                class="fc-view fc-month-view fc-basic-view"
                                                                style=""
                                                            >
                                                                <table class="">
                                                                    <thead
                                                                        class="fc-head"
                                                                    >
                                                                        <tr>
                                                                            <td
                                                                                class="fc-head-container fc-widget-header"
                                                                            >
                                                                                <div
                                                                                    class="fc-row fc-widget-header"
                                                                                >
                                                                                    <table
                                                                                        class=""
                                                                                    >
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-sun"
                                                                                                >
                                                                                                    <span
                                                                                                        >Sun</span
                                                                                                    >
                                                                                                </th>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-mon"
                                                                                                >
                                                                                                    <span
                                                                                                        >Mon</span
                                                                                                    >
                                                                                                </th>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-tue"
                                                                                                >
                                                                                                    <span
                                                                                                        >Tue</span
                                                                                                    >
                                                                                                </th>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-wed"
                                                                                                >
                                                                                                    <span
                                                                                                        >Wed</span
                                                                                                    >
                                                                                                </th>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-thu"
                                                                                                >
                                                                                                    <span
                                                                                                        >Thu</span
                                                                                                    >
                                                                                                </th>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-fri"
                                                                                                >
                                                                                                    <span
                                                                                                        >Fri</span
                                                                                                    >
                                                                                                </th>
                                                                                                <th
                                                                                                    class="fc-day-header fc-widget-header fc-sat"
                                                                                                >
                                                                                                    <span
                                                                                                        >Sat</span
                                                                                                    >
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                    </table>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody
                                                                        class="fc-body"
                                                                    >
                                                                        <tr>
                                                                            <td
                                                                                class="fc-widget-content"
                                                                            >
                                                                                <div
                                                                                    class="fc-scroller fc-day-grid-container"
                                                                                    style="overflow: hidden; height: 356px;"
                                                                                >
                                                                                    <div
                                                                                        class="fc-day-grid fc-unselectable"
                                                                                    >
                                                                                        <div
                                                                                            class="fc-row fc-week fc-widget-content fc-rigid"
                                                                                            style="height: 59px;"
                                                                                        >
                                                                                            <div
                                                                                                class="fc-bg"
                                                                                            >
                                                                                                <table
                                                                                                    class=""
                                                                                                >
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sun fc-other-month fc-past"
                                                                                                                data-date="2021-10-31"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-mon fc-past"
                                                                                                                data-date="2021-11-01"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-tue fc-past"
                                                                                                                data-date="2021-11-02"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-wed fc-past"
                                                                                                                data-date="2021-11-03"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-thu fc-past"
                                                                                                                data-date="2021-11-04"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-fri fc-past"
                                                                                                                data-date="2021-11-05"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sat fc-past"
                                                                                                                data-date="2021-11-06"
                                                                                                            ></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div
                                                                                                class="fc-content-skeleton"
                                                                                            >
                                                                                                <table>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sun fc-other-month fc-past"
                                                                                                                data-date="2021-10-31"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >31</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-mon fc-past"
                                                                                                                data-date="2021-11-01"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >1</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-tue fc-past"
                                                                                                                data-date="2021-11-02"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >2</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-wed fc-past"
                                                                                                                data-date="2021-11-03"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >3</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-thu fc-past"
                                                                                                                data-date="2021-11-04"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >4</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-fri fc-past"
                                                                                                                data-date="2021-11-05"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >5</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sat fc-past"
                                                                                                                data-date="2021-11-06"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >6</span
                                                                                                                >
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="fc-row fc-week fc-widget-content fc-rigid"
                                                                                            style="height: 59px;"
                                                                                        >
                                                                                            <div
                                                                                                class="fc-bg"
                                                                                            >
                                                                                                <table
                                                                                                    class=""
                                                                                                >
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sun fc-past"
                                                                                                                data-date="2021-11-07"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-mon fc-past"
                                                                                                                data-date="2021-11-08"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-tue fc-past"
                                                                                                                data-date="2021-11-09"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-wed fc-past"
                                                                                                                data-date="2021-11-10"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-thu fc-past"
                                                                                                                data-date="2021-11-11"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-fri fc-past"
                                                                                                                data-date="2021-11-12"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sat fc-past"
                                                                                                                data-date="2021-11-13"
                                                                                                            ></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div
                                                                                                class="fc-content-skeleton"
                                                                                            >
                                                                                                <table>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sun fc-past"
                                                                                                                data-date="2021-11-07"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >7</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-mon fc-past"
                                                                                                                data-date="2021-11-08"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >8</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-tue fc-past"
                                                                                                                data-date="2021-11-09"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >9</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-wed fc-past"
                                                                                                                data-date="2021-11-10"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >10</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-thu fc-past"
                                                                                                                data-date="2021-11-11"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >11</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-fri fc-past"
                                                                                                                data-date="2021-11-12"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >12</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sat fc-past"
                                                                                                                data-date="2021-11-13"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >13</span
                                                                                                                >
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="fc-row fc-week fc-widget-content fc-rigid"
                                                                                            style="height: 59px;"
                                                                                        >
                                                                                            <div
                                                                                                class="fc-bg"
                                                                                            >
                                                                                                <table
                                                                                                    class=""
                                                                                                >
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sun fc-past"
                                                                                                                data-date="2021-11-14"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-mon fc-past"
                                                                                                                data-date="2021-11-15"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-tue fc-past"
                                                                                                                data-date="2021-11-16"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-wed fc-past"
                                                                                                                data-date="2021-11-17"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-thu fc-past"
                                                                                                                data-date="2021-11-18"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-fri fc-past"
                                                                                                                data-date="2021-11-19"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sat fc-past"
                                                                                                                data-date="2021-11-20"
                                                                                                            ></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div
                                                                                                class="fc-content-skeleton"
                                                                                            >
                                                                                                <table>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sun fc-past"
                                                                                                                data-date="2021-11-14"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >14</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-mon fc-past"
                                                                                                                data-date="2021-11-15"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >15</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-tue fc-past"
                                                                                                                data-date="2021-11-16"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >16</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-wed fc-past"
                                                                                                                data-date="2021-11-17"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >17</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-thu fc-past"
                                                                                                                data-date="2021-11-18"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >18</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-fri fc-past"
                                                                                                                data-date="2021-11-19"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >19</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sat fc-past"
                                                                                                                data-date="2021-11-20"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >20</span
                                                                                                                >
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="fc-row fc-week fc-widget-content fc-rigid"
                                                                                            style="height: 59px;"
                                                                                        >
                                                                                            <div
                                                                                                class="fc-bg"
                                                                                            >
                                                                                                <table
                                                                                                    class=""
                                                                                                >
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sun fc-past"
                                                                                                                data-date="2021-11-21"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-mon fc-today "
                                                                                                                data-date="2021-11-22"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-tue fc-future"
                                                                                                                data-date="2021-11-23"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-wed fc-future"
                                                                                                                data-date="2021-11-24"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-thu fc-future"
                                                                                                                data-date="2021-11-25"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-fri fc-future"
                                                                                                                data-date="2021-11-26"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sat fc-future"
                                                                                                                data-date="2021-11-27"
                                                                                                            ></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div
                                                                                                class="fc-content-skeleton"
                                                                                            >
                                                                                                <table>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sun fc-past"
                                                                                                                data-date="2021-11-21"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >21</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-mon fc-today "
                                                                                                                data-date="2021-11-22"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >22</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-tue fc-future"
                                                                                                                data-date="2021-11-23"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >23</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-wed fc-future"
                                                                                                                data-date="2021-11-24"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >24</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-thu fc-future"
                                                                                                                data-date="2021-11-25"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >25</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-fri fc-future"
                                                                                                                data-date="2021-11-26"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >26</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sat fc-future"
                                                                                                                data-date="2021-11-27"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >27</span
                                                                                                                >
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td
                                                                                                                class="fc-event-container"
                                                                                                            >
                                                                                                                <a
                                                                                                                    class="fc-day-grid-event fc-h-event fc-event fc-start fc-end bg-danger fc-draggable"
                                                                                                                    ><div
                                                                                                                        class="fc-content"
                                                                                                                    >
                                                                                                                        <span
                                                                                                                            class="fc-time"
                                                                                                                            >3:40p</span
                                                                                                                        >
                                                                                                                        <span
                                                                                                                            class="fc-title"
                                                                                                                            >This
                                                                                                                            is
                                                                                                                            today
                                                                                                                            check
                                                                                                                            date</span
                                                                                                                        >
                                                                                                                    </div></a
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="fc-row fc-week fc-widget-content fc-rigid"
                                                                                            style="height: 59px;"
                                                                                        >
                                                                                            <div
                                                                                                class="fc-bg"
                                                                                            >
                                                                                                <table
                                                                                                    class=""
                                                                                                >
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sun fc-future"
                                                                                                                data-date="2021-11-28"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-mon fc-future"
                                                                                                                data-date="2021-11-29"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-tue fc-future"
                                                                                                                data-date="2021-11-30"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-wed fc-other-month fc-future"
                                                                                                                data-date="2021-12-01"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-thu fc-other-month fc-future"
                                                                                                                data-date="2021-12-02"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-fri fc-other-month fc-future"
                                                                                                                data-date="2021-12-03"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sat fc-other-month fc-future"
                                                                                                                data-date="2021-12-04"
                                                                                                            ></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div
                                                                                                class="fc-content-skeleton"
                                                                                            >
                                                                                                <table>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sun fc-future"
                                                                                                                data-date="2021-11-28"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >28</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-mon fc-future"
                                                                                                                data-date="2021-11-29"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >29</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-tue fc-future"
                                                                                                                data-date="2021-11-30"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >30</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-wed fc-other-month fc-future"
                                                                                                                data-date="2021-12-01"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >1</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-thu fc-other-month fc-future"
                                                                                                                data-date="2021-12-02"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >2</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-fri fc-other-month fc-future"
                                                                                                                data-date="2021-12-03"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >3</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sat fc-other-month fc-future"
                                                                                                                data-date="2021-12-04"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >4</span
                                                                                                                >
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td
                                                                                                                class="fc-event-container"
                                                                                                            >
                                                                                                                <a
                                                                                                                    class="fc-day-grid-event fc-h-event fc-event fc-start fc-end bg-success fc-draggable"
                                                                                                                    ><div
                                                                                                                        class="fc-content"
                                                                                                                    >
                                                                                                                        <span
                                                                                                                            class="fc-time"
                                                                                                                            >5:40p</span
                                                                                                                        >
                                                                                                                        <span
                                                                                                                            class="fc-title"
                                                                                                                            >Like
                                                                                                                            it?</span
                                                                                                                        >
                                                                                                                    </div></a
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div
                                                                                            class="fc-row fc-week fc-widget-content fc-rigid"
                                                                                            style="height: 61px;"
                                                                                        >
                                                                                            <div
                                                                                                class="fc-bg"
                                                                                            >
                                                                                                <table
                                                                                                    class=""
                                                                                                >
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sun fc-other-month fc-future"
                                                                                                                data-date="2021-12-05"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-mon fc-other-month fc-future"
                                                                                                                data-date="2021-12-06"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-tue fc-other-month fc-future"
                                                                                                                data-date="2021-12-07"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-wed fc-other-month fc-future"
                                                                                                                data-date="2021-12-08"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-thu fc-other-month fc-future"
                                                                                                                data-date="2021-12-09"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-fri fc-other-month fc-future"
                                                                                                                data-date="2021-12-10"
                                                                                                            ></td>
                                                                                                            <td
                                                                                                                class="fc-day fc-widget-content fc-sat fc-other-month fc-future"
                                                                                                                data-date="2021-12-11"
                                                                                                            ></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                            <div
                                                                                                class="fc-content-skeleton"
                                                                                            >
                                                                                                <table>
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sun fc-other-month fc-future"
                                                                                                                data-date="2021-12-05"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >5</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-mon fc-other-month fc-future"
                                                                                                                data-date="2021-12-06"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >6</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-tue fc-other-month fc-future"
                                                                                                                data-date="2021-12-07"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >7</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-wed fc-other-month fc-future"
                                                                                                                data-date="2021-12-08"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >8</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-thu fc-other-month fc-future"
                                                                                                                data-date="2021-12-09"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >9</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-fri fc-other-month fc-future"
                                                                                                                data-date="2021-12-10"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >10</span
                                                                                                                >
                                                                                                            </td>
                                                                                                            <td
                                                                                                                class="fc-day-top fc-sat fc-other-month fc-future"
                                                                                                                data-date="2021-12-11"
                                                                                                            >
                                                                                                                <span
                                                                                                                    class="fc-day-number"
                                                                                                                    >11</span
                                                                                                                >
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                            <td></td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <Chats />
    </div>
</template>

<script>
import Header from "../../headers/Header.vue";
import MenuParent from "../../navs/MenuParent.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";

export default {
    components: { Header, MenuParent, Chats },
    data() {
        return {


            InfosParent: [],

            users: []
        };
    },

    async mounted() {

        // Recuperer les donnes de cet utulisateurs dans la storage local

        if (localStorage.users) {
            this.users = JSON.parse(localStorage.getItem("users"));
        }

        // Allons chercher la session et le code etablissement ce cet enseigant

        const response = await this.callApi(
            "post",
            "api/parent/getInfosParent",
            this.users
        );

        this.InfosParent = response.data;

        // Garder les donnees de l'enseigant  dans le storage de navigateur

        localStorage.setItem("InfosParent", JSON.stringify(this.InfosParent));
    },

    methods: {

       SadeDataEnfant(data, i) {

            localStorage.setItem("datasEnfant", JSON.stringify(data));

            this.$router.push('DashParentGeneralites');

        }


    }
};
</script>
