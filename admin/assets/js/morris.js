$(function () {
    getMorris('line', 'line_register');
    // getMorris('bar', 'bar_chart');
    // getMorris('area', 'area_chart');
    // getMorris('donut', 'donut_chart');
});


function getMorris(type, element) {
    if (type === 'line') {
        Morris.Line({
            element: element,
            data: [ {
                    'day': 'Jan',
                    'registers': vars[0],
                    'sorned': null
                }, {
                    'day': 'Feb',
                    'registers': vars[1],
                    'sorned': null
                }, {
                    'day': 'Mar',
                    'registers': vars[2],
                    'sorned': null
                }, {
                    'day': 'Apr',
                    'registers': vars[3],
                    'sorned': null
                }, {
                    'day': 'May',
                    'registers': vars[4],
                    'sorned': null
                }, {
                    'day': 'Jun',
                    'registers': vars[5],
                    'sorned': null
                }, {
                    'day': 'Jul',
                    'registers': vars[6],
                    'sorned': null
                },{
                    'day': 'Aug',
                    'registers': vars[7],
                    'sorned': null
                },
                {
                    'day': 'Sep',
                    'registers': vars[8],
                    'sorned': null
                },{
                    'day': 'Oct',
                    'registers': vars[9],
                    'sorned': null
                },
                {
                    'day': 'Nov',
                    'registers': vars[10],
                    'sorned': null
                },{
                    'day': 'Dec',
                    'registers': vars[11],
                    'sorned': null
                }],
            xkey: 'day',
            ykeys: ['registers', 'sorned'],
            labels: ['회원가입 신청수', ''],
            lineColors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)'],
            lineWidth: 3,
            smooth: false,
            parseTime: false
        });
    } else if (type === 'bar') {
        Morris.Bar({
            element: element,
            data: [{
                x: '2011 Q1',
                y: 3,
                z: 2,
                a: 3
            }, {
                    x: '2011 Q2',
                    y: 2,
                    z: null,
                    a: 1
                }, {
                    x: '2011 Q3',
                    y: 0,
                    z: 2,
                    a: 4
                }, {
                    x: '2011 Q4',
                    y: 2,
                    z: 4,
                    a: 3
                }],
            xkey: 'x',
            ykeys: ['y', 'z', 'a'],
            labels: ['Y', 'Z', 'A'],
            barColors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(0, 150, 136)'],
        });
    } else if (type === 'area') {
        Morris.Area({
            element: element,
            data: [{
                period: '2010 Q1',
                iphone: 2666,
                ipad: null,
                itouch: 2647
            }, {
                    period: '2010 Q2',
                    iphone: 2778,
                    ipad: 2294,
                    itouch: 2441
                }, {
                    period: '2010 Q3',
                    iphone: 4912,
                    ipad: 1969,
                    itouch: 2501
                }, {
                    period: '2010 Q4',
                    iphone: 3767,
                    ipad: 3597,
                    itouch: 5689
                }, {
                    period: '2011 Q1',
                    iphone: 6810,
                    ipad: 1914,
                    itouch: 2293
                }, {
                    period: '2011 Q2',
                    iphone: 5670,
                    ipad: 4293,
                    itouch: 1881
                }, {
                    period: '2011 Q3',
                    iphone: 4820,
                    ipad: 3795,
                    itouch: 1588
                }, {
                    period: '2011 Q4',
                    iphone: 15073,
                    ipad: 5967,
                    itouch: 5175
                }, {
                    period: '2012 Q1',
                    iphone: 10687,
                    ipad: 4460,
                    itouch: 2028
                }, {
                    period: '2012 Q2',
                    iphone: 8432,
                    ipad: 5713,
                    itouch: 1791
                }],
            xkey: 'period',
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['iPhone', 'iPad', 'iPod Touch'],
            pointSize: 2,
            hideHover: 'auto',
            lineColors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(0, 150, 136)']
        });
    } else if (type === 'donut') {
        Morris.Donut({
            element: element,
            data: [{
                label: 'Jam',
                value: 25
            }, {
                    label: 'Frosted',
                    value: 40
                }, {
                    label: 'Custard',
                    value: 25
                }, {
                    label: 'Sugar',
                    value: 10
                }],
            colors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)'],
            formatter: function (y) {
                return y + '%'
            }
        });
    }
}