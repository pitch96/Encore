//
//  SGSideMenuViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/11/22.
//

import UIKit
import SideMenu

class FSGSideMenuViewController: UIViewController {

    @IBOutlet weak var sidemenuOption: UITableView!
    var arr = ["Home","profile", "Settings","Logout"]
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        sidemenuOption.delegate = self
        sidemenuOption.dataSource = self
    }
    
   
    
    
    
}
extension FSGSideMenuViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        return arr.count
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "SGSideMenuOptionTableViewCell", for: indexPath) as! SGSideMenuOptionTableViewCell
        //        cell.textLabel?.text = arr[indexPath.row]
        let arr =  arr[indexPath.row]
        cell.optionButton.setTitle(arr, for: .normal)
        return cell
    }

}
