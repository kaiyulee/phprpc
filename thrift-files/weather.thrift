namespace php Weather

include "bean.thrift"

service WeatherService 
{
    bean.Condition getCondition(1:i64 internal, 2:bean.Language language,3:bool isShort)
    bean.Aqi getAqi(1:i64 internal, 2:bean.Language language)
    map<i32,bean.Index> getIndexMap(1:i64 internal, 2:bean.Language language)
    list<bean.Forecast> getForecastList(1:i64 internal, 2:bean.Language language)
    list<bean.Hourly> getHourlyList(1:i64 internal, 2:bean.Language language)
    bean.LimitTail getLimitTail(1:i64 internal, 2:string date)
    list<bean.Alert> getAlert(1:i64 internal, 2:bean.Language language)
    bean.City getCity(1:i64 internal)
    list<bean.Festival> getFestival(1:bean.Language language, 2:string date)
    list<bean.Forecast> getForecastListFifteen(1:i64 internal, 2:bean.Language language)
    bean.ConditionAndAqi getConditionAndAqi(1:i64 internal, 2:bean.Language language,3:bool isShort);
    bean.Forecast getForecast(1:i64 internal, 2:bean.Language language);
}
