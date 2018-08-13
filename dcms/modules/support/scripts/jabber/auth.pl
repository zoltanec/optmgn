#!/usr/bin/perl -w
use strict;

use MIME::Base64;
$| = 1;
print "OK USER-EXISTS GET-PASSWORD CHECK-PASSWORD FREE\n";
# Our main loop
my $buf;
while(sysread (STDIN, $buf, 1024) > 0)
{
    my ($cmd, @args) = split ' ', $buf;
    $cmd =~ tr/[A-Z]/[a-z]/;
    $cmd =~ tr/-/_/;

    eval "print _cmd_$cmd(\@args), '\n'";
}

sub _cmd_user_exists
{
    my ($user, $realm) = @_;
    return "OK";
}
sub _cmd_get_password
{
    my ($user, $realm) = @_;
    return "OK MTIzNDU2";
}
sub _cmd_check_password
{
    my ($user, $encoded_pass, $realm) = @_;
    return "OK";
}
sub _cmd_set_password
{
    my ($user, $encoded_pass, $realm) = @_;
    return "OK";
}
sub _cmd_free
{
    exit(0);
}
