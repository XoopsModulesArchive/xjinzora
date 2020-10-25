F:\j2sdk1.4.2_03\bin\javac *.java
del upload.jar
F:\j2sdk1.4.2_03\bin\jar cvf upload.jar *.class
F:\j2sdk1.4.2_03\bin\jarsigner -verbose upload.jar mykey
del *.class