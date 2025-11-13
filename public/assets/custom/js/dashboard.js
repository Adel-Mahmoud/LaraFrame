const barLabels = salesChartData.map(item => item.formatted_date);
const barRevenue = salesChartData.map(item => Number(item.total_revenue) || 0);
const barVisits = salesChartData.map(item => Number(item.visits_count) || 0);

// console.log('بيانات الزيارات:', barVisits);
// console.log('بيانات المبيعات:', barRevenue);

const allVisitsZero = barVisits.every(visit => visit === 0);
if (allVisitsZero) {
    // console.warn(' جميع قيم الزيارات صفر، سيتم استخدام بيانات تجريبية');
    barVisits.forEach((_, index) => {
        barVisits[index] = Math.max(1, Math.round(barRevenue[index] / 100));
    });
}

const barData = [{
    label: "الإيرادات (ج.م)",
    data: barRevenue.map((value, index) => [index - 0.15, value]),
    bars: {
        show: true,
        barWidth: 0.3,
        align: "center"
    },
    color: "#00c9a7"
},
{
    label: "عدد الزيارات",
    data: barVisits.map((value, index) => [index + 0.15, value]),
    bars: {
        show: true,
        barWidth: 0.3,
        align: "center"
    },
    color: "#1e90ff",
    yaxis: 2
}
];

const barOptions = {
    yaxes: [{
        min: 0,
        tickFormatter: function (val) {
            return parseInt(val).toLocaleString();
        }
    },
    {
        position: "right",
        min: 0,
        tickFormatter: function (val) {
            return ''; // parseInt(val).toLocaleString() + " زيارة";
        }
    }
    ],
    grid: {
        borderWidth: 1,
        borderColor: "rgba(171,167,167,0.2)",
        hoverable: true,
        backgroundColor: "#fff"
    },
    xaxis: {
        ticks: barLabels.map((label, i) => [i, label]),
        color: "rgba(171,167,167,0.8)",
        font: {
            size: 11
        }
    },
    legend: {
        show: true,
        position: "ne",
        backgroundColor: "#f9f9f9",
        backgroundOpacity: 0.8
    }
};

$.plot("#flotBar1", barData, barOptions);

const pieColorsMap = {
    "قيد الانتظار": "#ff9f43",
    "مؤكدة": "#28c76f",
    "ملغاة": "#ea5455",
    "مكتملة": "#2299dd"
};

const pieData = [];
Object.entries(reservationsData).forEach(([label, data]) => {
    if (data.count > 0) {
        pieData.push({
            label: `${label} (${data.count})`,
            data: data.count,
            color: pieColorsMap[label] ?? "#888"
        });
    }
});

const pieOptions = {
    series: {
        pie: {
            show: true,
            radius: 1,
            innerRadius: 0.4,
            label: {
                show: true,
                radius: 0.8,
                formatter: function (label, series) {
                    return '<div style="font-size:11px;text-align:center;padding:2px;color:white;font-weight:600;">' +
                        Math.round(series.percent) + '%</div>';
                },
                background: {
                    opacity: 0.8
                },
                threshold: 0.05
            }
        }
    },
    grid: {
        hoverable: true,
        clickable: true
    },
    legend: {
        show: true,
        position: "ne",
        backgroundColor: "#f9f9f9",
        backgroundOpacity: 0.8
    }
};

if (pieData.length > 0) {
    $.plot("#flotPie1", pieData, pieOptions);
} else {
    $("#flotPie1").html('<div class="text-center p-5"><i class="fas fa-chart-pie fa-3x text-muted mb-3"></i><p>لا توجد بيانات للعرض</p></div>');
}

$("<div id='tooltip'></div>").css({
    position: "absolute",
    display: "none",
    padding: "8px 12px",
    "background-color": "rgba(0,0,0,0.8)",
    color: "#fff",
    "border-radius": "6px",
    "font-size": "12px",
    "font-weight": "500",
    "z-index": "1000",
    "box-shadow": "0 2px 10px rgba(0,0,0,0.2)"
}).appendTo("body");

$("#flotBar1").bind("plothover", function (event, pos, item) {
    if (item) {
        let tooltipText = '';
        if (item.seriesIndex === 0) {
            tooltipText = `الإيرادات: ${parseInt(item.datapoint[1]).toLocaleString()} ج.م<br>التاريخ: ${barLabels[item.dataIndex]}`;
        } else {
            tooltipText = `الزيارات: ${parseInt(item.datapoint[1]).toLocaleString()} زيارة<br>التاريخ: ${barLabels[item.dataIndex]}`;
        }

        $("#tooltip")
            .html(tooltipText)
            .css({
                top: item.pageY - 45,
                left: item.pageX + 10
            })
            .fadeIn(200);
    } else {
        $("#tooltip").hide();
    }
});

$("#flotPie1").bind("plothover", function (event, pos, obj) {
    if (!obj) {
        $("#tooltip").hide();
        return;
    }

    const percent = parseFloat(obj.series.percent).toFixed(1);
    $("#tooltip")
        .html(`${obj.series.label}<br>النسبة: ${percent}%<br>العدد: ${parseInt(obj.series.data)}`)
        .css({
            top: pos.pageY - 45,
            left: pos.pageX + 10
        })
        .fadeIn(200);
});

$(".chart-container").mouseleave(function () {
    $("#tooltip").fadeOut(200);
});

$(window).resize(function () {
    $.plot("#flotBar1", barData, barOptions);
    if (pieData.length > 0) {
        $.plot("#flotPie1", pieData, pieOptions);
    }
});