<?php

namespace RevoSystems\ProductLabel


class ProductLabel {

	public function render($json, $values, $time=1, $skip=0) {
		
	    $self->json   = $json;
	    $self->values = $values;

	    $mCurrentX   = 0;
	    $mCurrentY   = 0;
	    $final = "<html><head><style>@page{size:A4;margin:0;}@media print{html,body{width:%@mm;height:%@mm;}}</style><head></head><body>"; //, PAPER_WIDTH, PAPER_HEIGHT);
	    $times += $skip;
    
	    for(int $i = 0; $i < $times; i++){
        	if ($skip <= i) {
        		//final = [final append:str(@"<div style='%@ outline:1px solid black;'>%@</div>", self.getBoxSizeStyle, self.getObjects)];
	        	//$final = [final append:str(@"<div style='%@'>%@</div>", self.getBoxSizeStyle, self.getObjects)];
			$final = $final . "<div style='%@'>%@</div>"	;
	        }
        
        	$this->calculateNextLabelPosition();
        
	    }
	    return $final; //[final append:@"</body></html>"];
	}
}

//-(NSString*) getBoxSizeStyle {
//    NSDictionary* boxSizes = self.getBoxSizes;
    
//    return str(@"position: absolute; left: %fmm; top: %fmm; width: %@mm; height: %@mm;", mCurrentX, mCurrentY, boxSizes[@"width"], boxSizes[@"height"]);
    
//}

//-(NSDictionary*) getBoxSizes {
//    NSDictionary* paper =  self.papers[self.json[@"paper"]];
//    NSNumber* height = paper[@"height"];
//    NSNumber* width  = paper[@"width"];
    
    
//    if ([self.json[@"orientation"] isEqual:@"Portrait"]) {
//        return @{@"width": height, @"height": width};
//    }
//    return @{@"width": width, @"height": height};
//}

//-(NSDictionary*)papers{
//    return @{
//             @"1274"                        : @{@"width": @(106.0), @"height": @(36.68) },  //105  37.0
//             @"1284"                        : @{@"width": @(53.0),  @"height": @(20.96) },  //52.5 21.2
//             @"1286"                        : @{@"width": @(53.0),  @"height": @(29.34) },  //52.5 29.7
//             };
//}

//-(NSString*) getObjects {
//    return [self.json[@"objects"] reduce:^id(NSString* carry, NSDictionary* object) {
//        return str(@"%@%@", carry, [self getObject:object]);
//    } carry:@""];
//}

//-(NSString*)getObject:(NSDictionary*)object{
//    RVProductLabelObject* labelObject = [self.availableObjectClasses[object[@"type"]] new];
//    return [labelObject render:object values:self.values];
//}

