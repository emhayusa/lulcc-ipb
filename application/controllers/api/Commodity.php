<?php ${"\x47L\x4f\x42A\x4c\x53"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]="r\x65s\x70o\x6e\x73e";${"G\x4cO\x42A\x4c\x53"}["\x6dx\x74\x66\x73j\x77v\x67\x73n\x6dm\x71z\x73\x6d\x70\x5f\x6fy\x71\x7as\x65r\x70w\x75l\x75x\x63\x6e"]="c\x6fu\x6et";${"G\x4c\x4f\x42A\x4c\x53"}["\x76s\x61j\x77\x6cj\x66r\x5fg\x75e\x76\x68w\x6az\x68\x6dh\x71i\x73\x6f\x62"]="p\x61g\x65";${"\x47\x4c\x4f\x42A\x4c\x53"}["\x75\x6e\x66i\x5fb\x6d\x6dq\x72\x71h\x73\x71t\x63_\x6ec\x6fh\x6ck"]="\x73i\x7ae";${"G\x4cO\x42A\x4c\x53"}["g\x78\x74q\x5f\x78l\x6dw\x70w\x6b\x6bb\x61z\x5fv\x62x\x64\x6c"]="r\x6fw";${"\x47L\x4f\x42A\x4c\x53"}["h\x65\x5fv\x78v\x71n\x63p\x65\x75\x5f\x72u\x6f\x7as\x63c\x64\x6fi\x7a\x6fq\x63\x6e\x62h\x66\x72\x65t\x6ai\x71f\x61"]="i\x64";defined('BASEPATH')OR exit('No direct script access allowed');class Commodity extends CI_Controller{function __construct(){parent::__construct();$this->{"\x6c\x6f\x61\x64"}->{"\x6d\x6f\x64\x65\x6c"}('api/commodity_model','model_commodity');}function index(){${${"G\x4c\x4f\x42\x41L\x53"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]}=array('data'=>'api/commodity/data/<page>/<size>','id'=>'api/commodity/id/<id>');$this->{"\x6f\x75\x74\x70\x75\x74"}->{"\x73\x65\x74\x5f\x73\x74\x61\x74\x75\x73\x5f\x68\x65\x61\x64\x65\x72"}(200)->{"\x73\x65\x74\x5f\x63\x6f\x6e\x74\x65\x6e\x74\x5f\x74\x79\x70\x65"}('application/json','utf-8')->{"\x73\x65\x74\x5f\x6f\x75\x74\x70\x75\x74"}(json_encode(${${"G\x4cO\x42A\x4cS"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]},JSON_PRETTY_PRINT))->{"\x5f\x64\x69\x73\x70\x6c\x61\x79"}();exit;}function data($page=1,$size=10){${${"\x47L\x4fB\x41L\x53"}["\x6dx\x74\x66\x73j\x77v\x67\x73n\x6dm\x71z\x73\x6d\x70\x5f\x6fy\x71\x7as\x65r\x70w\x75l\x75x\x63\x6e"]}=$this->{"\x6d\x6f\x64\x65\x6c\x5f\x63\x6f\x6d\x6d\x6f\x64\x69\x74\x79"}->{"\x63\x6f\x75\x6e\x74\x5f\x61\x6c\x6c"}();${${"G\x4c\x4f\x42\x41L\x53"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]}=array('count'=>${${"G\x4cO\x42\x41\x4cS"}["\x6dx\x74\x66\x73j\x77v\x67\x73n\x6dm\x71z\x73\x6d\x70\x5f\x6fy\x71\x7as\x65r\x70w\x75l\x75x\x63\x6e"]},'page'=>intval(${${"G\x4cO\x42A\x4cS"}["\x76s\x61j\x77\x6cj\x66r\x5fg\x75e\x76\x68w\x6az\x68\x6dh\x71i\x73\x6f\x62"]}),'size'=>intval(${${"G\x4cO\x42\x41L\x53"}["\x75\x6e\x66i\x5fb\x6d\x6dq\x72\x71h\x73\x71t\x63_\x6ec\x6fh\x6ck"]}),'totalPages'=>ceil(${${"\x47L\x4fB\x41L\x53"}["\x6dx\x74\x66\x73j\x77v\x67\x73n\x6dm\x71z\x73\x6d\x70\x5f\x6fy\x71\x7as\x65r\x70w\x75l\x75x\x63\x6e"]}/${${"\x47\x4c\x4f\x42A\x4c\x53"}["\x75\x6e\x66i\x5fb\x6d\x6dq\x72\x71h\x73\x71t\x63_\x6ec\x6fh\x6ck"]}),'data'=>$this->{"\x6d\x6f\x64\x65\x6c\x5f\x63\x6f\x6d\x6d\x6f\x64\x69\x74\x79"}->{"\x67\x65\x74\x5f\x70\x61\x67\x65"}((${${"G\x4cO\x42\x41\x4c\x53"}["\x76s\x61j\x77\x6cj\x66r\x5fg\x75e\x76\x68w\x6az\x68\x6dh\x71i\x73\x6f\x62"]}-1)*${${"G\x4cO\x42A\x4c\x53"}["\x75\x6e\x66i\x5fb\x6d\x6dq\x72\x71h\x73\x71t\x63_\x6ec\x6fh\x6ck"]},${${"G\x4cO\x42\x41\x4cS"}["\x75\x6e\x66i\x5fb\x6d\x6dq\x72\x71h\x73\x71t\x63_\x6ec\x6fh\x6ck"]})->{"\x72\x65\x73\x75\x6c\x74"}());$this->{"\x6f\x75\x74\x70\x75\x74"}->{"\x73\x65\x74\x5f\x73\x74\x61\x74\x75\x73\x5f\x68\x65\x61\x64\x65\x72"}(200)->{"\x73\x65\x74\x5f\x63\x6f\x6e\x74\x65\x6e\x74\x5f\x74\x79\x70\x65"}('application/json','utf-8')->{"\x73\x65\x74\x5f\x6f\x75\x74\x70\x75\x74"}(json_encode(${${"G\x4c\x4f\x42A\x4cS"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]},JSON_PRETTY_PRINT))->{"\x5f\x64\x69\x73\x70\x6c\x61\x79"}();exit;}function id($id){${${"\x47\x4c\x4f\x42A\x4cS"}["g\x78\x74q\x5f\x78l\x6dw\x70w\x6b\x6bb\x61z\x5fv\x62x\x64\x6c"]}=$this->{"\x6d\x6f\x64\x65\x6c\x5f\x63\x6f\x6d\x6d\x6f\x64\x69\x74\x79"}->{"\x67\x65\x74\x5f\x62\x79\x5f\x69\x64"}(${${"\x47\x4cO\x42A\x4c\x53"}["h\x65\x5fv\x78v\x71n\x63p\x65\x75\x5f\x72u\x6f\x7as\x63c\x64\x6fi\x7a\x6fq\x63\x6e\x62h\x66\x72\x65t\x6ai\x71f\x61"]})->{"\x72\x6f\x77"}();if(!empty(${${"G\x4cO\x42\x41\x4cS"}["g\x78\x74q\x5f\x78l\x6dw\x70w\x6b\x6bb\x61z\x5fv\x62x\x64\x6c"]}))${${"\x47L\x4fB\x41\x4cS"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]}['data']=${${"G\x4cO\x42A\x4cS"}["g\x78\x74q\x5f\x78l\x6dw\x70w\x6b\x6bb\x61z\x5fv\x62x\x64\x6c"]};else${${"G\x4cO\x42A\x4cS"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]}['message']="n\x6f \x64a\x74a\x20f\x6f\x75\x6ed";$this->{"\x6f\x75\x74\x70\x75\x74"}->{"\x73\x65\x74\x5f\x73\x74\x61\x74\x75\x73\x5f\x68\x65\x61\x64\x65\x72"}(200)->{"\x73\x65\x74\x5f\x63\x6f\x6e\x74\x65\x6e\x74\x5f\x74\x79\x70\x65"}('application/json','utf-8')->{"\x73\x65\x74\x5f\x6f\x75\x74\x70\x75\x74"}(json_encode(${${"G\x4c\x4fB\x41L\x53"}["l\x5fh\x6ce\x67y\x75\x5fu\x75o\x69m\x7al\x5fi\x77u\x76u\x74\x61x\x66h\x61\x72h\x7a\x70\x7ac\x74x"]},JSON_PRETTY_PRINT))->{"\x5f\x64\x69\x73\x70\x6c\x61\x79"}();exit;}}
