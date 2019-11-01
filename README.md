# tagVerifier
Sometimes we have to many css files and some cloud based servers (like Oracle Commerce Cloud) stop working without saying which file is wrong. This php file checks all files (for now just .less) in Oracle Commerce Cloud structure. 

The only thing that's needed is to put it where dcu files are downloaded to use the lessChecker. 

To use koChecker, put it on the same folder of display.template file. It's going to print every (open & close) ko lines which have more than 10 lines between them, and the number of lines.

Future improvements are:
<ul>
<li>Generalize to work with any sort of file structure</li>
<li>Check html tags using</li>
</ul>
