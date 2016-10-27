namespace php Bean
//语言定义
enum Language
{
    LANG_ZH = 1,
    LANG_EN = 2,
    LANG_TW = 4,
    LANG_HK = 8
}
//月相
enum MOONPHASE
{
    MOON_NEW = 1,
    MOON_WAXINGCRESCENT = 2,
    MOON_FIRST = 3,
    MOON_WAXINGGIBBOUS = 4,
    MOON_FULL = 5,
    MOON_WANINGGIBBOUS = 6,
    MOON_LAST = 7,
    MOON_WANINGCRESCENT = 8
}
//实况
struct Condition 
{
    1:required  i32     temperature,        //温度
    2:required  string  condition,          //实况描述
    3:required  i32     icon,               //实况ICON
    4:required  i32     humidity,           //相对湿度
    5:required  i32     pressure,           //大气压
    6:required  i32     windLevel,          //风级
    7:required  double  windSpeed,          //风速
    8:required  string  windDir             //风向
    9:required  string  uvi,                //紫外线
    10:required Sun     sun,                //日出日落
    11:required i64     updatetime,         //更新时间  
    12:required i32     weatherCode,        //天气情况代号(不区分白天和晚上)
    13:required i32     bgCode              //天气背景代号(不区分白天和晚上)              
}
//日出日落
struct Sun
{
    1:required  i64 sunRise,                //日出
    2:required  i64 sunSet                  //日落
}
//月出月落
struct Moon
{
    1:required i64  moonRise,               //月出
    2:required i64  moonSet,                //月落
    3:required i32  moonPhase               //月相
}
//AQI
struct Aqi 
{
    1:required  i32     value,              //空气指数
    2:required  i32     level,              //空指级别
    3:required  string  desc,               //空指描述
    4:optional  i32     co,                 //二氧化碳
    5:optional  i32     no2,                //二氧化氮
    6:optional  i32     o3,                 //臭氧
    7:optional  i32     pm10,               //PM10
    8:optional  i32     pm25,               //PM25
    9:optional  i32     so2                 //二氧化硫
}
//生活指数
struct Index 
{
    1:required  string  description,        //指数描述
    2:required  string  title,              //指数标题
    3:required  string  level,              //指数等级
    4:required  i32     code                //指数代号
}
//预报
struct Forecast 
{
    1:required  i32     iconDay,            //白天实况ICON
    2:required  i32     iconNight,          //晚上实况ICON
    3:required  string  conditionDay,       //白天实况描述
    4:required  string  conditionNight,     //晚上实况描述
    5:required  i32     temperatureDay,     //白天温度
    6:required  i32     temperatureNight,   //晚上温度
    7:required  string  windLevelDay,       //白天风级
    8:required  string  windLevelNight,     //晚上风级
    9:required  string  windDirectionDay,   //白天风向
    10:required string  windDirectionNight, //晚上风向
    11:required double  windSpeedDay,       //白天风速
    12:required double  windSpeedNight,     //晚上风速
    13:required string  predictDate,        //预报日期
    14:optional Sun     sun,                //日出日落
    15:optional Moon    moon                //月出月落
}
//小时预报
struct Hourly
{
    1:required  i32     icon,               //天气ICON
    2:required  string  condition,          //天气实况
    3:required  i32     temperature,        //温度
    4:required  i32     realfeel,           //体感
    5:required  i32     humidity,           //相对湿度
    6:required  i32     pressure,           //气压
    7:required  i64     windLevel,          //风级
    8:required  string  windDir,            //风向
    9:required  i32     uvi,                //紫外线
    10:required double  windSpeed,          //风速
    11:required i32     dewPoint,           //露点
    12:required i64     predictTime         //预报时间          
}
//限行
struct LimitTail
{
    1:required  string  rule,               //具体限行
    2:required  string  desc                //限行描述
}
//预警
struct Alert
{
    1:required  i32     icon,               //预警ICON            
    2:required  string  content,            //预警内容
    3:required  string  title,              //预警标题
    4:required  string  level,              //预警级别
    5:required  i64     publishTime,        //发布时间
    6:required  i64     reliveTime,         //解除时间
    7:required  string  name;               //预警名称
}
//城市
struct City 
{
    1:required  i64     cityId,             //城市ID  
    2:required  i64     internal,           //城市INTERNAL
    3:required  string  citynameCN,         //城市名中文
    4:required  string  citynameEN,         //城市名英文
    5:required  string  citynameTW,         //城市名台湾
    6:required  string  citynameHK,         //城市名香港
    7:required  double  latitude,           //纬度
    8:required  double  longitude,          //经度
    9:required  i32     timezone,           //时区
    10:required i32     country             //国家
}
//节假日
struct Festival
{
    1:required  string  name                //节假日名称
}

//实况&AQI
struct ConditionAndAqi 
{
    1:required Condition condition,         //实况
    2:optional Aqi      aqi                 //空气指数
}
