Apex.grid = {
    padding: {
        right: 0,
        left: 0
    }
}, Apex.dataLabels = {
    enabled: !1
};
var randomizeArray = function(e) {
        for (var t, o, a = e.slice(), i = a.length; 0 !== i;) o = Math.floor(Math.random() * i), t = a[i -= 1], a[i] = a[o], a[o] = t;
        return a
    },
    sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46],
    colorPalette = ["#2f2f7e", "#1bc943", "#f4772e", "#f83245", "#11c5db"],
    monthlyEarningsOpt = {
        chart: {
            type: "area",
            height: 260,
            background: "#eff4f7",
            sparkline: {
                enabled: !0
            }
        },
        stroke: {
            curve: "straight"
        },
        fill: {
            type: "solid",
            opacity: 1
        },
        series: [{
            data: randomizeArray(sparklineData)
        }],
        xaxis: {
            crosshairs: {
                width: 1
            }
        },
        yaxis: {
            min: 0,
            max: 130
        },
        colors: ["#dce6ec"]
    },
    monthlyEarningsChart = new ApexCharts(document.querySelector("#monthly-earnings-chart"), monthlyEarningsOpt),
    optionsArea = {
        chart: {
            height: 340,
            type: "area",
            zoom: {
                enabled: !1
            }
        },
        stroke: {
            curve: "straight"
        },
        colors: colorPalette,
        series: [{
            name: "Blog",
            data: [{
                x: 0,
                y: 0
            }, {
                x: 4,
                y: 5
            }, {
                x: 5,
                y: 3
            }, {
                x: 9,
                y: 8
            }, {
                x: 14,
                y: 4
            }, {
                x: 18,
                y: 5
            }, {
                x: 25,
                y: 0
            }]
        }, {
            name: "Social Media",
            data: [{
                x: 0,
                y: 0
            }, {
                x: 4,
                y: 6
            }, {
                x: 5,
                y: 4
            }, {
                x: 14,
                y: 8
            }, {
                x: 18,
                y: 5.5
            }, {
                x: 21,
                y: 6
            }, {
                x: 25,
                y: 0
            }]
        }, {
            name: "External",
            data: [{
                x: 0,
                y: 0
            }, {
                x: 2,
                y: 5
            }, {
                x: 5,
                y: 4
            }, {
                x: 10,
                y: 11
            }, {
                x: 14,
                y: 4
            }, {
                x: 18,
                y: 8
            }, {
                x: 25,
                y: 0
            }]
        }],
        fill: {
            opacity: 1
        },
        markers: {
            size: 0,
            style: "hollow",
            hover: {
                opacity: 5
            }
        },
        tooltip: {
            intersect: !0,
            shared: !1
        },
        xaxis: {
            tooltip: {
                enabled: !1
            },
            labels: {
                show: !1
            },
            axisTicks: {
                show: !1
            }
        },
        yaxis: {
            tickAmount: 4,
            max: 12,
            axisBorder: {
                show: !1
            },
            axisTicks: {
                show: !1
            },
            labels: {
                style: {
                    color: "#78909c"
                }
            }
        },
        legend: {
            show: !1
        }
    },
    chartArea = new ApexCharts(document.querySelector("#area"), optionsArea);
chartArea.render();
var optionDonut_6 = {
        chart: {
            type: "donut_6",
            width: "100%"
        },
        dataLabels: {
            enabled: !1
        },
        plotOptions: {
            pie: {
                donut_6: {
                    size: "55%"
                }
            },
            stroke: {
                colors: void 0
            }
        },
        colors: colorPalette,
        series: [21, 23, 19, 14],
        labels: ["Accepted", "In-iransit", "Deliverd", "Returned"],
        legend: {
            position: "bottom"
        }
    },
    donut_6 = new ApexCharts(document.querySelector("#donut_6"), optionDonut_6);

function trigoSeries(e, t) {
    for (var o = [], a = 0; a < e; a++) o.push((Math.sin(a / t) * (a / t) + a / t + 1) * (2 * t));
    return o
}
donut_6.render();
var optionsLine = {
        chart: {
            height: 340,
            type: "line",
            zoom: {
                enabled: !1
            }
        },
        plotOptions: {
            stroke: {
                width: 4,
                curve: "smooth"
            }
        },
        colors: colorPalette,
        series: [{
            name: "Day Time",
            data: trigoSeries(52, 20)
        }, {
            name: "Night Time",
            data: trigoSeries(52, 27)
        }],
        markers: {
            size: 0
        },
        grid: {},
        xaxis: {
            labels: {
                show: !1
            },
            axisTicks: {
                show: !1
            },
            tooltip: {
                enabled: !1
            }
        },
        yaxis: {
            tickAmount: 2,
            labels: {
                show: !1
            },
            axisBorder: {
                show: !1
            },
            axisTicks: {
                show: !1
            },
            min: 0
        },
        legend: {
            position: "top",
            horizontalAlign: "left"
        }
    },
    chartLine = new ApexCharts(document.querySelector("#line"), optionsLine);
chartLine.render().then((function() {
    var e = document.querySelector("#wrapper");
    e.contentDocument && (e.style.height = e.contentDocument.body.scrollHeight + 20 + "px")
}));
var mobileDonut_6 = function() {
    $(window).width() < 768 ? donut_6.updateOptions({
        plotOptions: {
            pie: {}
        },
        legend: {
            position: "bottom"
        }
    }, !1, !1) : donut_6.updateOptions({
        plotOptions: {
            pie: {}
        },
        legend: {
            position: "left"
        }
    }, !1, !1)
};
$(window).resize((function() {
    mobileDonut_6()
}));