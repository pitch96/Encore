//
//  CartViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 28/12/22.
//

import UIKit

class CartViewController: UIViewController, UICollectionViewDelegate, UICollectionViewDataSource {
    
    

    @IBOutlet weak var ticketCollectionView: UICollectionView!
    var arr = ["Image", "Event Title", "Title Ticket", "Unit Price", "Quantity", "Ammount", "Action"]
    override func viewDidLoad() {
        super.viewDidLoad()
        ticketCollectionView.delegate = self
        ticketCollectionView.dataSource = self

        // Do any additional setup after loading the view.
    }
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
       return arr.count
    }
    
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "CartCollectionViewCell", for: indexPath) as! CartCollectionViewCell
        cell.labelTicket.text = arr[indexPath.row]
        return cell
    }

   
}
