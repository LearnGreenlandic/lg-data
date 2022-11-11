#!/bin/bash
# find . -type f -name '*.fst' -exec sh gen.sh '{}' \;
B=$(basename $1 .fst)
echo "$B up"
foma -q -e "load $B.fst" -e 'random-upper 5000' -e quit | awk '{print $2}' | sort | uniq > "$B.up"
echo "$B down"
cat "$B.up" | flookup -x -i "$B.fst" | egrep -v '^$' > "$B.down"
paste "$B.down" "$B.up" > "$B.txt"
rm -fv "$B.down" "$B.up"
