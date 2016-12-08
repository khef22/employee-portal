export function YesOrNoFilter() {
    return function(booleanVar) {
    	console.log(booleanVar);
        return (booleanVar ? "Yes" : "No");
    };
}