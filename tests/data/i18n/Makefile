# Makefile for Eventum po files.
# (c) 2015 Elan Ruusamäe <glen@delfi.ee>

POFILES     := $(wildcard  */*/*.po)
MOFILES     := $(patsubst %.po,%.mo,$(POFILES))

all: $(MOFILES)

# create mo from the po files
%.mo: %.po
	msgfmt --statistics $< -o $(subst .po,,$<).mo.tmp && mv $(subst .po,,$<).mo.tmp $(subst .po,,$<).mo

clean:
	rm -f $(MOFILES)
