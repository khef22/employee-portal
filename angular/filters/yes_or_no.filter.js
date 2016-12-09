export function YesOrNoFilter() {
    return function(booleanVar) {
        return (booleanVar ? "Yes" : "No");
    };
}