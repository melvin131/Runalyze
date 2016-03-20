<?php

use Runalyze\Configuration;
use Runalyze\Util\LocalTime;

/**
 * Generated by hand
 */
class ParserLOGBOOKSingleTest extends PHPUnit_Framework_TestCase {

	public function testHRdataFromLaps() {
		$XML = simplexml_load_string_utf8('
<Activity referenceId="7ba9cc85-3015-49b5-a423-087597f2ca89" startTime="2015-01-15T15:16:31Z" timeZoneUtcOffset="1" hasStartTime="true" totalTime="1705.96" totalDistance="5305.3" totalCalories="355" notes="1. Versuch mit den Rollskatern" name="Michael" categoryId="2611799c-e453-4fc1-be7e-23ed58bb0621" categoryName="Cross Skating" location="Ostbucht" useEnteredData="false">
  <Metadata created="2015-01-15T16:15:48Z" modified="2015-01-15T16:18:02Z" />
  <Laps>
	<Lap startTime="2015-01-15T15:16:31Z" totalTime="366.519" totalDistance="1000" avgHeartRate="131" totalCalories="68" />
	<Lap startTime="2015-01-15T15:23:00Z" totalTime="366.111" totalDistance="1000" avgHeartRate="139" totalCalories="74" />
	<Lap startTime="2015-01-15T15:29:51Z" totalTime="317.56399999999996" totalDistance="1000" avgHeartRate="146" totalCalories="68" />
	<Lap startTime="2015-01-15T15:35:09Z" totalTime="306.738" totalDistance="1000" avgHeartRate="150" totalCalories="67" />
	<Lap startTime="2015-01-15T15:40:15Z" totalTime="268.033" totalDistance="1000" avgHeartRate="154" totalCalories="59" />
	<Lap startTime="2015-01-15T15:44:43Z" totalTime="80.997" totalDistance="305.3" avgHeartRate="159" totalCalories="19" />
  </Laps>
  <DistanceMarkers>
	<DistanceMarker distance="1000" />
	<DistanceMarker distance="2000" />
	<DistanceMarker distance="3000" />
	<DistanceMarker distance="4000" />
	<DistanceMarker distance="5000" />
  </DistanceMarkers>
  <Weather conditions="PartClouds" />
  <GPSRoute>
	<TrackData version="4"><![CDATA[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]]></TrackData>
  </GPSRoute>
  <DistanceTrack>
	<TrackData version="4"><![CDATA[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]]></TrackData>
  </DistanceTrack>
  <HeartRateTrack>
	<TrackData version="4"><![CDATA[AU88GS8AAAAAPwAAZwJpBWoJawxsDm0TcBdyHHQfdyB3JHkoei18MX41fzqAP4FDgUiDTIRQhVSFWIVchWGGZYdph26Icoh3iHiIeomAiIWGiYeNiJGIlYiZh56FooWlhaiFrIWwhbWFuoa+hsKGxojLic+J04nYidqK3YnjieiI7Ijwh/WI+4hPPRkvAAAAADwAAIYDgwSABn0YfhyBIIIlgiqCLoMzhDiFPIdCiEaIS4hOh0+HZH9lf2Z/aoJvg3SFeIh6iH+IhIqHioiLi4uMi5GLloqbiJyHnoeih6OGpoaohaqFsIe0ibiLvozEjMqNy43PjNON1ozYjN2L34vhi+WK54vpi+uLYz4ZLwAAAAA/AACBAYECgQV+Bn0LehF8FnwcfiF/JoErhDCGNYg6iD+KQotDi0SLSYtNi1GMVo5Zjl6PY49pkG6RdJF5kH6OhI6Kj4+QlZCaj52On42hjaWNqo2ujrKOt469j8KPxpDMkdKR2JPck+CT4ZPkk+iT6ZLske2R8o/zj/iO/Y3/jWQ/GS8AAAAARAAAjQKNBYwHjAmMCosNixGLEowXihyLIYwliyqMLoowijWJOok/ikWLSotOjFOOV41bjF+KZYtpi22LcY11jXmNfo2CjYaPipGOkZGUk5SXlZuVoJaklqiWqZarla2VsZS1k7eUupO/k8OTx5TNlNGU1pXalt6W4Jbil+iX7Jftl/GY85f2l/qXZEAZLwAAAAA8AACYBpcLlw2XD5cTlxSXF5camB+ZJJkpmS2ZMZk1mDqXQJdFlUiVSpVOlVOUV5Vbll+WY5dml2eXa5hwmHWZeZl+mYOYiJiOmJKXlpaclaGUpZSrk7CTtJK4kr2Rw5HIkM2P0o7WjtuP35DjkOeR65Luk/KU95X7l2RBGS8AAAAARgAAmAWYCZkMmQ2ZEZkVmhaaGZodmiCaIZolmyibKpsvmzKbM5o3mjqaPJlAmUWZSJhNmFGXVZdall6WZJRolGyUcZV1lnaWeJZ6lnuWfJaAl4WXipeOmJKYlpiamZ+ZpJmoma2Zspm2mbuYv5jFl8mWzZfSl9aY2pjemeCY4pnkmOeY7JjwmfWZ+Zr9m2VCGS8AAAAANwAAmwScCZ0OnRKdFp0anh6eIp4mniydLZ0vnTOcNZw3mzuaP5pEm0ibTJtQm1WbWZtdm2CbY5xnnGqca5tvnHSceZx9nIKchZ2GnYmdjZ6QnZSemJ6cnqGfpqCqoK+gtKC5oL2hwqHHoMug0J/WnwAAAAAAAAAA]]></TrackData>
  </HeartRateTrack>
  <ExtensionData>
	<Plugins>
	  <Plugin id="264fbd17-8a81-4cfa-b739-77c70bcefb53" text="SRTM1_VP_N46E014"><![CDATA[ArcBAAAfiwgA7vW3VAD/jVQxktswDJRlS1WqzKS4J1ydXvJMmhT8QLpUyTf0jJN/kUlvuVQhZ5wfpLouX8iEILHUEkf5jjMYkgBIAIslhx+PX//++/258qP2svdy0Fn2je4b1e10fyAb1k1Bf7jjj3mnsdo3nN1TjjbuVhzU1RZs0KE28X1/py6s2wIuH3TeFfxr2sMfc0OCHA7kUxM+B4oP4Z5w32q6qyZ5pDw5h9bMW7Kn8xbPPfmV7msLeq6x1D/uG9cNH9TBa+TG+DIGHNOe51o5n9rY2oIP9+e1N2B7VvIBH9iO/JtCvMb4MW925jzjafkCTLifpXdme3ivxtK7sHhyPU1hbeO+9u/sjY397X/GPGAbv6mS3nLf9rEt6LivW3+GxbrZWG/FsDywvHktTknw39h/ZSs27/nvvscH/h+5h/ew2MJG8r0ufz5VMm7uXJ0epurJy205V4ubqsXPv1zUyRC7+IlexrJ03t57e+/1nd7TVbMXsWGIjvU3mk/+7Meffboz5tEHu8RLsVyMvcY5B8GQHOEv+T9prpzDHKRsj/XEO+Ej+1njIN90B52ds7XPe+zTGvZQk4s48SzCQ/CcFRec9T7D+HAM916XyeM1Vd+fp2Dj/vDIa89xyP38fgh4D+OXi497SXrJ4dtzH3KS+rmnqSdL3hPGhvvMuUifgDFjB/xXfsX6mG+4U3LmGIz3SfkoZ6thSjgiv9lgwPWOHmPwSAS5Io9VOuVo7Bc4jn6Cw9hbjFDrWnuXzsCf8eR4nNM4Ri5Inbg31DD2w+KO3tbHOMOU6gGPExcVTzmHNx246f2v7pLqlVjCPbkr4OGmF/yaNda67zIb+sv18N9gMeD70aPwNjRf3AkffrPQ4cwty2XlZeDXMGV8POmbsn2aUy7nrD9yHtimOlx8O+AV3jbjH4av5fruqO8+vmd5d/FfXP8bOS865CciPTmpgAMvuR37HjjgmAfExSXvG9fKuYKX3Bf7piRP/VPSP8b/J3iHvmRYqK/wVnwEB1kHbrop3Sf8Ey6m2MeL9iDw1v+Xl//htghIwA0AAA==]]></Plugin>
	  <Plugin id="fe7e1057-325b-40ab-be5f-9303b8d07093" text="id=7768748|sync=2015-01-15T16:18:02.6011449Z" />
	</Plugins>
  </ExtensionData>
</Activity>');

		$Parser = new ParserLOGBOOKSingle('', $XML);
		$Parser->parse();

		$this->assertTrue( !$Parser->failed() );
		$this->assertEquals('2015-01-15 16:16:31', LocalTime::date('Y-m-d H:i:s', $Parser->object()->getTimestamp()));
		$this->assertEquals( $Parser->object()->getPulseAvg(), 144 );
	}

}
