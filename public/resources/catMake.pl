use strict;
use warnings;

my @list=();
my $match = '';
my ($sp,$ge,$fm)=('','','');

open my $FH,"<","./rbcL/info/All.txt";
open my $OFH,">","./rbcL/category/species.txt";
open my $OFH2,">","./rbcL/category/genus.txt";
open my $OFH3,">","./rbcL/category/family.txt";

my %hsp = ();
my %hge = ();
my %hfm = ();

while(my $line=<$FH>){
	chomp $line;
	@list=split/\t/,$line;
	$list[2] =~/sp\|(.+)\sge\|(.+)\sfm\|(.+)\sph.+$/;
	($sp,$ge,$fm)=($1,$2,$3);
	$hsp{$sp}++;
	$hge{$ge}++;
	$hfm{$fm}++;
}
close $FH;

my %hspc=();
my %hgec=();
my %hfmc=();

open $FH,"<","./rbcL/info/curated.txt";
while(my $line=<$FH>){
	chomp $line;
	@list=split/\t/,$line;
	$list[2] =~/sp\|(.+)\sge\|(.+)\sfm\|(.+)\sph.+$/;
	($sp,$ge,$fm)=($1,$2,$3);
	$hspc{$sp}++;
	$hgec{$ge}++;
	$hfmc{$fm}++;
}
close $FH;

foreach my $key(sort keys %hsp)
{
	if(!exists $hspc{$key}){$hspc{$key}=0;}
	print $OFH "$key\t$hsp{$key}\t$hspc{$key}\n";
}
foreach my $key(sort keys %hge)
{
	if(!exists $hgec{$key}){$hgec{$key}=0;}
	print $OFH2 "$key\t$hge{$key}\t$hgec{$key}\n";
}
foreach my $key(sort keys %hfm)
{
	if(!exists $hfmc{$key}){$hfmc{$key}=0;}
	print $OFH3 "$key\t$hfm{$key}\t$hfmc{$key}\n";
}


close $OFH;
close $OFH2;
close $OFH3;

exit;
