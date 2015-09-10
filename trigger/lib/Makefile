LIBDIR=/usr/lib

install:
	gcc -Wall -m64 -fPIC -I/usr/include/mysql -I. -shared lib_mysqludf_sys.c -o $(LIBDIR)/lib_mysqludf_sys.so
