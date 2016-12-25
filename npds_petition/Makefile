FTPDIR=/var/ftp/public/phpPetitions/
HTMLDIR=/home/iris/fs/public_html/petitions
EXCLUDE='*CVS*'

cvs:
	@echo cvs commit
	cvs commit

tarball:
	rm -rf /tmp/phpPetitions
	mkdir /tmp/phpPetitions
	rsync -Ca . /tmp/phpPetitions
	tar -C /tmp -zcf ../phpPetitions-${VERSION}.${SUBVERSION}.tgz phpPetitions
	rm -rf /tmp/phpPetitions

zip:
	rm -rf /tmp/phpPetitions
	mkdir /tmp/phpPetitions
	rsync -Ca . /tmp/phpPetitions
	#tar -C /tmp -zcf ../phpPetitions-${VERSION}.${SUBVERSION}.tgz phpPetitions
	#rm -rf /tmp/phpPetitions


